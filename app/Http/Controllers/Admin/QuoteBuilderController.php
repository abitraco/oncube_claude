<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class QuoteBuilderController extends Controller
{
    public function builder(Request $request, $id)
    {
        // Check session authentication
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'quotes']);
        }

        $quoteRequest = QuoteRequest::findOrFail($id);

        // Check if quote has been sent - prevent editing
        if ($quoteRequest->status === QuoteRequest::STATUS_QUOTE_SENT && $quoteRequest->quote_sent_at) {
            return redirect()->route('admin.quotes')
                ->with('error', 'This quote has already been sent to the customer and cannot be edited.');
        }

        return view('admin.quote-builder', compact('quoteRequest'));
    }

    public function saveQuote(Request $request, $id)
    {
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'quotes']);
        }

        $quoteRequest = QuoteRequest::findOrFail($id);

        // Check if quote has been sent - prevent editing
        if ($quoteRequest->status === QuoteRequest::STATUS_QUOTE_SENT && $quoteRequest->quote_sent_at) {
            return redirect()->route('admin.quotes')
                ->with('error', 'This quote has already been sent to the customer and cannot be edited.');
        }

        $validated = $request->validate([
            'quote_template' => 'required|in:en,ko',
            'quote_number' => 'required|string',
            'quote_date' => 'required|date',
            'valid_until' => 'required|date',
            'items' => 'required|array',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric',
            'items.*.unit_price' => 'required|numeric',
            'payment_terms' => 'nullable|string',
            'delivery_terms' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Re-index items array to ensure sequential keys (0, 1, 2...)
        // This prevents issues with non-sequential keys when items are removed
        if (isset($validated['items'])) {
            $validated['items'] = array_values($validated['items']);
        }

        \Log::info('Saving quote data', [
            'quote_id' => $id,
            'template' => $validated['quote_template'],
            'items_count' => count($validated['items']),
            'quote_number' => $validated['quote_number']
        ]);

        // Save quote data - The model's mutator will handle json_encode automatically
        $quoteRequest->quote_template = $validated['quote_template'];
        $quoteRequest->quote_data = $validated;  // Mutator will json_encode this
        $quoteRequest->status = QuoteRequest::STATUS_PENDING;
        $quoteRequest->save();

        \Log::info('Quote data saved to database', [
            'quote_id' => $id,
            'saved_successfully' => true
        ]);

        // Refresh to get the saved data with proper accessor
        $quoteRequest = $quoteRequest->fresh();

        // Automatically regenerate PDF
        try {
            $pdf = $this->createPdfFromData($quoteRequest);

            // Save PDF to public storage
            $filename = 'quote_' . $quoteRequest->id . '_' . time() . '.pdf';
            $path = 'public/quotes/' . $filename;

            // Ensure directory exists
            if (!Storage::exists('public/quotes')) {
                Storage::makeDirectory('public/quotes');
            }

            Storage::put($path, $pdf->Output('', 'S'));

            // Store the public path (without 'public/' prefix for asset URL)
            $publicPath = 'quotes/' . $filename;

            // Update quote request with new PDF path
            $quoteRequest->update([
                'quote_pdf' => $publicPath
            ]);

            \Log::info('Quote PDF generated successfully', [
                'quote_id' => $quoteRequest->id,
                'pdf_path' => $publicPath
            ]);
        } catch (\Exception $e) {
            \Log::error('PDF generation failed', [
                'quote_id' => $quoteRequest->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.quote.review', $id)
                ->with('warning', 'Quote saved but PDF generation failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.quote.review', $id)
            ->with('success', 'Quote saved and PDF generated successfully. Please review before sending.');
    }

    public function review(Request $request, $id)
    {
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'quotes']);
        }

        $quoteRequest = QuoteRequest::findOrFail($id);

        if (!$quoteRequest->quote_data) {
            return redirect()->route('admin.quote.builder', $id)
                ->with('error', 'Please fill out the quote first.');
        }

        return view('admin.quote-review', compact('quoteRequest'));
    }

    public function generatePdf(Request $request, $id)
    {
        if ($request->session()->get('admin_authenticated') !== true) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $quoteRequest = QuoteRequest::findOrFail($id);

        if (!$quoteRequest->quote_data) {
            return response()->json(['error' => 'No quote data found'], 400);
        }

        try {
            // Generate PDF from quote data
            $pdf = $this->createPdfFromData($quoteRequest);

            // Save PDF to public storage so it's accessible via web
            $filename = 'quote_' . $quoteRequest->id . '_' . time() . '.pdf';
            $path = 'public/quotes/' . $filename;
            Storage::put($path, $pdf->Output('', 'S'));

            // Store the public path (without 'public/' prefix for asset URL)
            $publicPath = 'quotes/' . $filename;

            // Update quote request
            $quoteRequest->update([
                'quote_pdf' => $publicPath
            ]);

            \Log::info('PDF regenerated successfully via button', [
                'quote_id' => $quoteRequest->id,
                'pdf_path' => $publicPath
            ]);

            return response()->json([
                'success' => true,
                'pdf_url' => asset('storage/' . $publicPath)
            ]);

        } catch (\Exception $e) {
            \Log::error('PDF regeneration failed', [
                'quote_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function send(Request $request, $id)
    {
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'quotes']);
        }

        $quoteRequest = QuoteRequest::findOrFail($id);

        if (!$quoteRequest->quote_pdf) {
            return back()->with('error', 'Please generate PDF first.');
        }

        try {
            // Send email to customer
            Mail::send('emails.quote-customer', ['quote' => $quoteRequest], function ($message) use ($quoteRequest) {
                $message->to($quoteRequest->company_email, $quoteRequest->contact_name)
                    ->subject('Quote for Your Inquiry - ONCUBE GLOBAL')
                    ->attach(storage_path('app/public/' . $quoteRequest->quote_pdf));
            });

            // Send copy to admin
            Mail::send('emails.quote-admin-copy', ['quote' => $quoteRequest], function ($message) use ($quoteRequest) {
                $message->to('kmmccc@gmail.com', 'ONCUBE Admin')
                    ->subject('Quote Sent - ' . $quoteRequest->company_name)
                    ->attach(storage_path('app/public/' . $quoteRequest->quote_pdf));
            });

            // Update status
            $quoteRequest->update([
                'status' => QuoteRequest::STATUS_QUOTE_SENT,
                'quote_sent_at' => now()
            ]);

            return redirect()->route('admin.quotes')
                ->with('success', 'Quote sent successfully to ' . $quoteRequest->company_email);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    private function createPdfFromData($quoteRequest)
    {
        $data = $quoteRequest->quote_data;
        
        // Use the new modern template
        $html = view('pdf.quote-modern', [
            'quote' => $quoteRequest,
            'data' => $data
        ])->render();

        // Ensure temp directory exists
        if (!file_exists(storage_path('app/mpdf'))) {
            mkdir(storage_path('app/mpdf'), 0755, true);
        }

        // Use mPDF for Korean language support
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
            'tempDir' => storage_path('app/mpdf'),
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ]);

        $mpdf->WriteHTML($html);

        return $mpdf;
    }
}
