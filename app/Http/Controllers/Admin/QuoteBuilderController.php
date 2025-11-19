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

        return view('admin.quote-builder', compact('quoteRequest'));
    }

    public function saveQuote(Request $request, $id)
    {
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'quotes']);
        }

        $quoteRequest = QuoteRequest::findOrFail($id);

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

        // Save quote data
        $quoteRequest->update([
            'quote_template' => $validated['quote_template'],
            'quote_data' => $validated,
            'status' => QuoteRequest::STATUS_PENDING,
        ]);

        return redirect()->route('admin.quote.review', $id)
            ->with('success', 'Quote saved successfully. Please review before sending.');
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
            return redirect()->route('admin.login', ['redirect' => 'quotes']);
        }

        $quoteRequest = QuoteRequest::findOrFail($id);

        if (!$quoteRequest->quote_data) {
            return response()->json(['error' => 'No quote data found'], 400);
        }

        try {
            // Generate PDF from quote data
            $pdf = $this->createPdfFromData($quoteRequest);

            // Save PDF to storage
            $filename = 'quote_' . $quoteRequest->id . '_' . time() . '.pdf';
            $path = 'quotes/' . $filename;
            Storage::put($path, $pdf->output());

            // Update quote request
            $quoteRequest->update([
                'quote_pdf' => $path
            ]);

            return response()->json([
                'success' => true,
                'pdf_url' => Storage::url($path)
            ]);

        } catch (\Exception $e) {
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
                    ->attach(storage_path('app/' . $quoteRequest->quote_pdf));
            });

            // Send copy to admin
            Mail::send('emails.quote-admin-copy', ['quote' => $quoteRequest], function ($message) use ($quoteRequest) {
                $message->to('kmmccc@gmail.com', 'ONCUBE Admin')
                    ->subject('Quote Sent - ' . $quoteRequest->company_name)
                    ->attach(storage_path('app/' . $quoteRequest->quote_pdf));
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
        $template = $quoteRequest->quote_template;

        // Load PDF library
        $pdf = app('dompdf.wrapper');

        // Generate HTML from template
        $html = view('pdf.quote-' . $template, [
            'quote' => $quoteRequest,
            'data' => $data
        ])->render();

        $pdf->loadHTML($html);
        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }
}
