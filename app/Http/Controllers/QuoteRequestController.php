<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\QuoteRequest;

class QuoteRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_email' => 'required|email|max:255',
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'contact_name' => 'required|string|max:255',
            'product_url' => 'nullable|url|max:1000',
            'inquiry_type' => 'required|in:견적문의,대량구매,사업제휴,기타',
            'quantity' => 'nullable|string|max:100',
            'message' => 'required|string|max:5000',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
            'privacy_agreed' => 'required|accepted',
        ]);

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('quote-attachments', 'public');
        }

        // Store quote request
        $quoteRequest = QuoteRequest::create([
            'company_email' => $validated['company_email'],
            'company_name' => $validated['company_name'],
            'phone' => $validated['phone'],
            'contact_name' => $validated['contact_name'],
            'product_url' => $validated['product_url'] ?? null,
            'inquiry_type' => $validated['inquiry_type'],
            'quantity' => $validated['quantity'] ?? null,
            'message' => $validated['message'],
            'attachment' => $attachmentPath,
            'privacy_agreed' => true,
            'locale' => app()->getLocale(),
            'status' => QuoteRequest::STATUS_PENDING,
        ]);

        // Send confirmation email to customer
        try {
            Mail::send('emails.quote-request-received', ['quoteRequest' => $quoteRequest], function ($message) use ($quoteRequest) {
                $message->to($quoteRequest->company_email, $quoteRequest->contact_name)
                    ->subject('Quote Request Received - ONCUBE GLOBAL');
            });
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send customer confirmation email: ' . $e->getMessage());
        }

        // Send notification email to admin
        try {
            Mail::send('emails.quote-request-admin', ['quoteRequest' => $quoteRequest], function ($message) use ($quoteRequest) {
                $message->to('kmmccc@gmail.com', 'ONCUBE Admin')
                    ->subject('New Quote Request - ' . $quoteRequest->company_name);
            });
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send admin notification email: ' . $e->getMessage());
        }

        return back()->with('success', __('Your quote request has been submitted successfully. We will contact you within 24 hours.'));
    }
}
