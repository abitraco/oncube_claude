@extends('layouts.email')

@section('title', 'New Quote Request')

@section('content')
    <h2 style="margin-top:0;margin-bottom:20px;font-size:20px;line-height:28px;font-weight:bold;color:#FF6B00;">
        🔔 New Quote Request
    </h2>
    
    <p style="margin:0 0 20px 0;">A new quote request has been submitted from the website.</p>

    <div style="background-color:#f8f9fa;border-left:4px solid #002748;padding:20px;margin-bottom:25px;border-radius:4px;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:16px;color:#002748;text-transform:uppercase;">Customer Information</h3>
        <table role="presentation" style="width:100%;border:none;border-spacing:0;">
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;width:120px;">Company:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quoteRequest->company_name }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;">Contact:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quoteRequest->contact_name }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;">Email:</td>
                <td style="padding-bottom:8px;color:#333;"><a href="mailto:{{ $quoteRequest->company_email }}" style="color:#002748;text-decoration:none;">{{ $quoteRequest->company_email }}</a></td>
            </tr>
            <tr>
                <td style="font-weight:bold;color:#555;">Phone:</td>
                <td style="color:#333;"><a href="tel:{{ $quoteRequest->phone }}" style="color:#002748;text-decoration:none;">{{ $quoteRequest->phone }}</a></td>
            </tr>
        </table>
    </div>

    <div style="background-color:#f8f9fa;border-left:4px solid #002748;padding:20px;margin-bottom:25px;border-radius:4px;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:16px;color:#002748;text-transform:uppercase;">Inquiry Details</h3>
        <table role="presentation" style="width:100%;border:none;border-spacing:0;">
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;width:120px;">Type:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quoteRequest->inquiry_type }}</td>
            </tr>
            @if($quoteRequest->quantity)
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;">Quantity:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quoteRequest->quantity }}</td>
            </tr>
            @endif
            @if($quoteRequest->product_url)
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;">Product URL:</td>
                <td style="padding-bottom:8px;color:#333;"><a href="{{ $quoteRequest->product_url }}" target="_blank" style="color:#002748;text-decoration:underline;">View Product</a></td>
            </tr>
            @endif
            <tr>
                <td style="font-weight:bold;color:#555;">Submitted:</td>
                <td style="color:#333;">{{ $quoteRequest->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        </table>
    </div>

    @if($quoteRequest->message)
    <div style="background-color:#f8f9fa;border-left:4px solid #002748;padding:20px;margin-bottom:25px;border-radius:4px;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:16px;color:#002748;text-transform:uppercase;">Customer Message</h3>
        <p style="margin:0;white-space:pre-wrap;color:#333;">{{ $quoteRequest->message }}</p>
    </div>
    @endif

    @if($quoteRequest->attachment)
    <div style="background-color:#fff3cd;border:1px solid #ffc107;color:#856404;padding:15px;border-radius:4px;margin-bottom:25px;">
        <strong>📎 Attachment:</strong> File uploaded - check admin panel
    </div>
    @endif

    <div style="text-align:center;margin:30px 0;">
        <a href="{{ url('/admin/quotes') }}" style="background-color:#002748;color:#ffffff;display:inline-block;font-family:Arial,sans-serif;font-size:16px;font-weight:bold;line-height:44px;text-align:center;text-decoration:none;width:220px;border-radius:4px;-webkit-text-size-adjust:none;">View in Admin Panel</a>
    </div>

    <p style="margin:0;font-size:14px;color:#666;">
        <strong>Action Required:</strong> Please review this request and prepare a quotation for the customer.
    </p>
@endsection

