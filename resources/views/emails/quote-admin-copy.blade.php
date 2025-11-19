@extends('layouts.email')

@section('title', 'Quote Sent Confirmation')

@section('content')
    <h2 style="margin-top:0;margin-bottom:20px;font-size:20px;line-height:28px;font-weight:bold;color:#002748;">
        Quote Sent - Admin Copy
    </h2>
    
    <div style="background-color:#e8f5e9;border:1px solid #c8e6c9;color:#2e7d32;padding:15px;text-align:center;border-radius:4px;margin-bottom:25px;">
        <strong>Quote has been sent successfully.</strong>
    </div>

    <div style="background-color:#f8f9fa;border-left:4px solid #002748;padding:20px;margin-bottom:25px;border-radius:4px;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:16px;color:#002748;text-transform:uppercase;">Quote Details</h3>
        <table role="presentation" style="width:100%;border:none;border-spacing:0;">
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;width:120px;">Quote Number:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quote->quote_data['quote_number'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;">Sent At:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quote->quote_sent_at ? $quote->quote_sent_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s') }}</td>
            </tr>
        </table>
    </div>

    <div style="background-color:#f8f9fa;border-left:4px solid #002748;padding:20px;margin-bottom:25px;border-radius:4px;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:16px;color:#002748;text-transform:uppercase;">Customer Information</h3>
        <table role="presentation" style="width:100%;border:none;border-spacing:0;">
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;width:120px;">Company:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quote->company_name }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;">Contact:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quote->contact_name }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;">Email:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quote->company_email }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;color:#555;">Phone:</td>
                <td style="color:#333;">{{ $quote->phone }}</td>
            </tr>
        </table>
    </div>

    @if(isset($quote->quote_data['items']))
    <div style="background-color:#f8f9fa;border-left:4px solid #002748;padding:20px;margin-bottom:25px;border-radius:4px;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:16px;color:#002748;text-transform:uppercase;">Items Summary</h3>
        @php
            $total = 0;
            foreach ($quote->quote_data['items'] as $item) {
                $total += $item['quantity'] * $item['unit_price'];
            }
        @endphp
        <table role="presentation" style="width:100%;border:none;border-spacing:0;">
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;width:120px;">Items Count:</td>
                <td style="padding-bottom:8px;color:#333;">{{ count($quote->quote_data['items']) }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;color:#555;">Total Amount:</td>
                <td style="font-weight:bold;color:#002748;">${{ number_format($total, 2) }}</td>
            </tr>
        </table>
    </div>
    @endif

    <p style="margin:0;">Please see the attached PDF for complete quote details.</p>
@endsection

