<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\QuoteRequest;
use Illuminate\Http\Request;

class QuoteHistoryController extends Controller
{
    public function index(Request $request)
    {
        // Check session authentication
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'quote-history']);
        }

        // Get only quote requests that have been sent (with PDFs)
        $query = QuoteRequest::whereNotNull('quote_pdf')
            ->whereNotNull('quote_sent_at')
            ->orderBy('quote_sent_at', 'desc');

        // Apply filters if provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'like', '%' . $search . '%')
                  ->orWhere('contact_name', 'like', '%' . $search . '%')
                  ->orWhere('company_email', 'like', '%' . $search . '%')
                  ->orWhere('quote_data', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('template') && $request->template) {
            $query->where('quote_template', $request->template);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $quotes = $query->paginate(20);

        return view('admin.quote-history', compact('quotes'));
    }

    public function view(Request $request, $id)
    {
        // Check session authentication
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'quote-history']);
        }

        $quoteRequest = QuoteRequest::findOrFail($id);

        if (!$quoteRequest->quote_pdf) {
            return redirect()->route('admin.quote-history')
                ->with('error', 'No quote PDF found for this request.');
        }

        return view('admin.quote-review', compact('quoteRequest'));
    }

    public function downloadPdf(Request $request, $id)
    {
        // Check session authentication
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'quote-history']);
        }

        $quoteRequest = QuoteRequest::findOrFail($id);

        if (!$quoteRequest->quote_pdf) {
            return back()->with('error', 'No quote PDF found.');
        }

        $filePath = storage_path('app/public/' . $quoteRequest->quote_pdf);

        if (!file_exists($filePath)) {
            return back()->with('error', 'PDF file not found on server.');
        }

        $data = $quoteRequest->quote_data;
        $filename = 'Quote_' . ($data['quote_number'] ?? $quoteRequest->id) . '.pdf';

        return response()->download($filePath, $filename);
    }
}
