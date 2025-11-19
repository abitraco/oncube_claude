<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation from ONCUBE GLOBAL</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #002748; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
        <h1 style="margin: 0; font-size: 24px;">ONCUBE GLOBAL</h1>
        <p style="margin: 5px 0 0 0; font-size: 14px;">Industrial & Semiconductor Equipment</p>
    </div>

    <div style="background: #f9f9f9; padding: 30px; border: 1px solid #ddd; border-top: none; border-radius: 0 0 5px 5px;">
        <p style="font-size: 16px; margin-top: 0;">Dear {{ $quote->contact_name }},</p>

        <p>Thank you for your inquiry. Please find attached our quotation for your review.</p>

        <div style="background: white; border-left: 4px solid #19BD0A; padding: 15px; margin: 20px 0;">
            <p style="margin: 0;"><strong>Quote Number:</strong> {{ $quote->quote_data['quote_number'] ?? 'N/A' }}</p>
            <p style="margin: 5px 0 0 0;"><strong>Valid Until:</strong> {{ isset($quote->quote_data['valid_until']) ? date('F d, Y', strtotime($quote->quote_data['valid_until'])) : 'N/A' }}</p>
        </div>

        <p>Please review the attached PDF quotation and let us know if you have any questions or would like to proceed with the order.</p>

        <p>We look forward to serving your equipment needs.</p>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
            <p style="margin: 5px 0;"><strong>Best regards,</strong></p>
            <p style="margin: 5px 0;">ONCUBE GLOBAL Team</p>
            <p style="margin: 5px 0; font-size: 14px; color: #666;">
                Tel: +82-10-4846-0846<br>
                License: 416-19-94501
            </p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #888;">
        <p>This is an automated email. Please do not reply directly to this message.</p>
        <p>&copy; {{ date('Y') }} ONCUBE GLOBAL. All rights reserved.</p>
    </div>
</body>
</html>
