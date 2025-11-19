@extends('layouts.email')

@section('title', 'Quotation from ONCUBE GLOBAL')

@section('content')
    <h2 style="margin-top:0;margin-bottom:20px;font-size:20px;line-height:28px;font-weight:bold;color:#002748;">
        Quotation for {{ $quote->contact_name }}
    </h2>
    
    <p style="margin:0 0 15px 0;">Dear {{ $quote->contact_name }},</p>

    <p style="margin:0 0 20px 0;">Thank you for your inquiry. We are pleased to provide you with the attached quotation for your review.</p>

    <div style="background-color:#f8f9fa;border-left:4px solid #19BD0A;padding:20px;margin-bottom:25px;border-radius:4px;">
        <table role="presentation" style="width:100%;border:none;border-spacing:0;">
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;width:120px;">Quote Number:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quote->quote_data['quote_number'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;">Date:</td>
                <td style="padding-bottom:8px;color:#333;">{{ isset($quote->quote_data['quote_date']) ? date('F d, Y', strtotime($quote->quote_data['quote_date'])) : date('F d, Y') }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;color:#555;">Valid Until:</td>
                <td style="color:#333;">{{ isset($quote->quote_data['valid_until']) ? date('F d, Y', strtotime($quote->quote_data['valid_until'])) : 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <p style="margin:0 0 20px 0;">Please review the attached PDF quotation for detailed pricing and terms. If you have any questions or would like to proceed with the order, please simply reply to this email.</p>

    <div style="text-align:center;margin:30px 0;">
        <a href="https://oncube.cloud" style="background-color:#002748;color:#ffffff;display:inline-block;font-family:Arial,sans-serif;font-size:16px;font-weight:bold;line-height:44px;text-align:center;text-decoration:none;width:200px;border-radius:4px;-webkit-text-size-adjust:none;">Contact Us</a>
    </div>

    <p style="margin:0 0 10px 0;">We look forward to serving your equipment needs.</p>

    <p style="margin:0;">Best regards,<br><strong>ONCUBE GLOBAL Team</strong></p>
@endsection

