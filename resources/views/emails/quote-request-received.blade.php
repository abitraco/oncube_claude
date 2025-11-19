@extends('layouts.email')

@section('title', 'Quote Request Received')

@section('content')
    <h2 style="margin-top:0;margin-bottom:20px;font-size:20px;line-height:28px;font-weight:bold;color:#002748;">
        We Received Your Request
    </h2>
    
    <p style="margin:0 0 15px 0;">Dear {{ $quoteRequest->contact_name }},</p>

    <p style="margin:0 0 20px 0;">Thank you for submitting your quote request to ONCUBE GLOBAL. We have successfully received your inquiry and our team is already reviewing it.</p>

    <div style="background-color:#e8f5e9;border:1px solid #c8e6c9;color:#2e7d32;padding:15px;text-align:center;border-radius:4px;margin-bottom:25px;">
        <strong>Your request has been successfully logged!</strong>
    </div>

    <div style="background-color:#f8f9fa;border-left:4px solid #002748;padding:20px;margin-bottom:25px;border-radius:4px;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:16px;color:#002748;text-transform:uppercase;">Request Details</h3>
        <table role="presentation" style="width:100%;border:none;border-spacing:0;">
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;width:120px;">Company:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quoteRequest->company_name }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;">Inquiry Type:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quoteRequest->inquiry_type }}</td>
            </tr>
            @if($quoteRequest->quantity)
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;">Quantity:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quoteRequest->quantity }}</td>
            </tr>
            @endif
            <tr>
                <td style="font-weight:bold;color:#555;">Submitted:</td>
                <td style="color:#333;">{{ $quoteRequest->created_at->format('F d, Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <p style="margin:0 0 20px 0;">Our team will prepare a detailed quotation tailored to your needs. We typically respond within <strong>24-48 business hours</strong>.</p>

    <p style="margin:0 0 10px 0;">If you have any urgent questions or additional information to add, please feel free to reply to this email.</p>

    <p style="margin:0;">Best regards,<br><strong>ONCUBE GLOBAL Team</strong></p>
@endsection

