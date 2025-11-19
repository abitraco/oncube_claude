<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote Request Received</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #002748; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
        <h1 style="margin: 0; font-size: 24px;">ONCUBE GLOBAL</h1>
        <p style="margin: 5px 0 0 0; font-size: 14px;">Thank you for your inquiry</p>
    </div>

    <div style="background: #f9f9f9; padding: 30px; border: 1px solid #ddd; border-top: none; border-radius: 0 0 5px 5px;">
        <p style="font-size: 16px; margin-top: 0;">Dear {{ $quoteRequest->contact_name }},</p>

        <p>Thank you for submitting your quote request to ONCUBE GLOBAL. We have successfully received your inquiry.</p>

        <div style="background: #19BD0A; color: white; padding: 15px; text-align: center; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 0; font-size: 18px; font-weight: bold;">Your request has been received!</p>
        </div>

        <div style="background: white; border-left: 4px solid #002748; padding: 15px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #002748;">Your Request Details</h3>
            <p style="margin: 5px 0;"><strong>Company:</strong> {{ $quoteRequest->company_name }}</p>
            <p style="margin: 5px 0;"><strong>Inquiry Type:</strong> {{ $quoteRequest->inquiry_type }}</p>
            @if($quoteRequest->quantity)
            <p style="margin: 5px 0;"><strong>Quantity:</strong> {{ $quoteRequest->quantity }}</p>
            @endif
            <p style="margin: 5px 0;"><strong>Submitted:</strong> {{ $quoteRequest->created_at->format('F d, Y H:i') }}</p>
        </div>

        <p>Our team will review your request and prepare a detailed quotation for you. We typically respond within 24-48 business hours.</p>

        <p>If you have any urgent questions, please feel free to contact us directly.</p>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
            <p style="margin: 5px 0;"><strong>Contact Information:</strong></p>
            <p style="margin: 5px 0; font-size: 14px;">
                Tel: +82-10-4846-0846<br>
                Email: kmmccc@gmail.com<br>
                License: 416-19-94501
            </p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #888;">
        <p>This is an automated confirmation email.</p>
        <p>&copy; {{ date('Y') }} ONCUBE GLOBAL. All rights reserved.</p>
    </div>
</body>
</html>
