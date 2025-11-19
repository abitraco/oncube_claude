<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote Sent Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #002748; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
        <h1 style="margin: 0; font-size: 24px;">Quote Sent - Admin Copy</h1>
    </div>

    <div style="background: #f9f9f9; padding: 30px; border: 1px solid #ddd; border-top: none; border-radius: 0 0 5px 5px;">
        <p style="font-size: 16px; margin-top: 0;">Quote has been sent successfully.</p>

        <div style="background: white; border: 1px solid #ddd; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #002748;">Quote Details</h3>
            <p style="margin: 5px 0;"><strong>Quote Number:</strong> {{ $quote->quote_data['quote_number'] ?? 'N/A' }}</p>
            <p style="margin: 5px 0;"><strong>Sent At:</strong> {{ $quote->quote_sent_at ? $quote->quote_sent_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s') }}</p>
        </div>

        <div style="background: white; border: 1px solid #ddd; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #002748;">Customer Information</h3>
            <p style="margin: 5px 0;"><strong>Company:</strong> {{ $quote->company_name }}</p>
            <p style="margin: 5px 0;"><strong>Contact:</strong> {{ $quote->contact_name }}</p>
            <p style="margin: 5px 0;"><strong>Email:</strong> {{ $quote->company_email }}</p>
            <p style="margin: 5px 0;"><strong>Phone:</strong> {{ $quote->phone }}</p>
        </div>

        @if(isset($quote->quote_data['items']))
        <div style="background: white; border: 1px solid #ddd; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #002748;">Items Summary</h3>
            @php
                $total = 0;
                foreach ($quote->quote_data['items'] as $item) {
                    $total += $item['quantity'] * $item['unit_price'];
                }
            @endphp
            <p style="margin: 5px 0;"><strong>Number of Items:</strong> {{ count($quote->quote_data['items']) }}</p>
            <p style="margin: 5px 0;"><strong>Total Amount:</strong> ${{ number_format($total, 2) }}</p>
        </div>
        @endif

        <p style="margin-top: 20px;">Please see the attached PDF for complete quote details.</p>
    </div>

    <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #888;">
        <p>&copy; {{ date('Y') }} ONCUBE GLOBAL Admin System</p>
    </div>
</body>
</html>
