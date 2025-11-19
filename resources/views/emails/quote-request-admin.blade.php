<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Quote Request</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #FF6B00; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
        <h1 style="margin: 0; font-size: 24px;">🔔 New Quote Request</h1>
        <p style="margin: 5px 0 0 0; font-size: 14px;">ONCUBE GLOBAL Admin Alert</p>
    </div>

    <div style="background: #f9f9f9; padding: 30px; border: 1px solid #ddd; border-top: none; border-radius: 0 0 5px 5px;">
        <p style="font-size: 16px; margin-top: 0;">A new quote request has been submitted.</p>

        <div style="background: white; border: 1px solid #ddd; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #002748;">Customer Information</h3>
            <p style="margin: 5px 0;"><strong>Company:</strong> {{ $quoteRequest->company_name }}</p>
            <p style="margin: 5px 0;"><strong>Contact Name:</strong> {{ $quoteRequest->contact_name }}</p>
            <p style="margin: 5px 0;"><strong>Email:</strong> <a href="mailto:{{ $quoteRequest->company_email }}">{{ $quoteRequest->company_email }}</a></p>
            <p style="margin: 5px 0;"><strong>Phone:</strong> <a href="tel:{{ $quoteRequest->phone }}">{{ $quoteRequest->phone }}</a></p>
        </div>

        <div style="background: white; border: 1px solid #ddd; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #002748;">Inquiry Details</h3>
            <p style="margin: 5px 0;"><strong>Type:</strong> {{ $quoteRequest->inquiry_type }}</p>
            @if($quoteRequest->quantity)
            <p style="margin: 5px 0;"><strong>Quantity:</strong> {{ $quoteRequest->quantity }}</p>
            @endif
            @if($quoteRequest->product_url)
            <p style="margin: 5px 0;"><strong>Product URL:</strong> <a href="{{ $quoteRequest->product_url }}" target="_blank">{{ $quoteRequest->product_url }}</a></p>
            @endif
            <p style="margin: 5px 0;"><strong>Submitted:</strong> {{ $quoteRequest->created_at->format('Y-m-d H:i:s') }}</p>
        </div>

        @if($quoteRequest->message)
        <div style="background: white; border: 1px solid #ddd; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #002748;">Customer Message</h3>
            <p style="margin: 0; white-space: pre-wrap;">{{ $quoteRequest->message }}</p>
        </div>
        @endif

        @if($quoteRequest->attachment)
        <div style="background: #fff3cd; border: 1px solid #ffc107; padding: 15px; margin: 20px 0;">
            <p style="margin: 0;"><strong>📎 Attachment:</strong> File uploaded - check admin panel</p>
        </div>
        @endif

        <div style="background: #002748; color: white; padding: 15px; text-align: center; border-radius: 5px; margin: 20px 0;">
            <a href="{{ url('/admin/quotes') }}" style="color: white; text-decoration: none; font-weight: bold; font-size: 16px;">
                View in Admin Panel →
            </a>
        </div>

        <p style="font-size: 14px; color: #666; margin-top: 20px;">
            <strong>Action Required:</strong> Please review this request and prepare a quotation for the customer.
        </p>
    </div>

    <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #888;">
        <p>&copy; {{ date('Y') }} ONCUBE GLOBAL Admin System</p>
    </div>
</body>
</html>
