# Quote System Testing Guide

## ✅ Email Configuration
- Email driver set to `log` - emails will be written to `storage/logs/laravel.log`
- No SMTP server required for testing

## 📝 Test Data Created
Two test quote requests have been added:

1. **Test Company Ltd** (English)
   - Contact: John Doe
   - Email: test@example.com
   - Phone: +82-10-1234-5678
   - Type: 견적문의
   - Quantity: 100

2. **한국 반도체 주식회사** (Korean)
   - Contact: Kim Min-soo
   - Email: kim@koreancompany.co.kr
   - Phone: +82-2-1234-5678
   - Type: 대량구매
   - Quantity: 500

## 🧪 Testing Steps

### 1. Access Admin Panel
1. Open: `https://oncube_claude.test/admin/quotes`
2. Login with password: `oncube2025`
3. You should see 2 quote requests with:
   - Status badges showing "대기중" (pending)
   - Green "Create Quote" buttons
   - Blue "Details" buttons

### 2. Test Quote Builder
1. Click "Create Quote" on "Test Company Ltd"
2. Verify the form shows:
   - ✅ Pre-filled customer info (company, contact, email, phone)
   - ✅ Template selector (English/Korean radio buttons)
   - ✅ Auto-generated quote number: Q-20251119-0001
   - ✅ Today's date pre-filled
   - ✅ Valid until date (30 days from now)
   - ✅ One default line item row

3. Select **English Template**

4. Add line items:
   - Item 1:
     - Description: "Industrial Air Compressor Model AC-5000"
     - Quantity: 50
     - Unit Price: 2500.00
     - Expected Amount: $125,000.00

   - Click "+ Add Item" for Item 2:
     - Description: "Pneumatic Control Valve Set"
     - Quantity: 100
     - Unit Price: 150.00
     - Expected Amount: $15,000.00

5. Verify totals calculate automatically:
   - Subtotal: $140,000.00
   - Total Amount: $140,000.00

6. Review Terms & Conditions (pre-filled):
   - Payment Terms: "100% advance payment before shipment"
   - Delivery Terms: "EXW (Ex Works) Korea"
   - Notes: Multi-line notes about pricing, lead time, warranty

7. Click **"Save & Review Quote"**

### 3. Test Quote Review Page
1. You should be redirected to review page showing:
   - ✅ Customer information summary
   - ✅ Quote details (number, date, valid until)
   - ✅ All line items in a formatted table
   - ✅ Calculated totals
   - ✅ Terms and conditions
   - ✅ "Generate PDF" button
   - ✅ "Send Quote" button
   - ✅ "Back to Edit" button

### 4. Test PDF Generation
1. Click **"Generate PDF"** button
2. Check for success message
3. Verify PDF is created in `storage/app/quotes/` directory
4. The database should be updated with `quote_pdf` path

### 5. Test Email Sending
1. Click **"Send Quote"** button
2. Check `storage/logs/laravel.log` for email content
3. You should see 2 emails logged:
   - Email to customer (test@example.com) with quote PDF
   - Email to admin (kmmccc@gmail.com) with quote copy

4. Verify quote status changes to "견적서 발송됨" (quote_sent)

### 6. Test Back to Quote List
1. Return to: `https://oncube_claude.test/admin/quotes`
2. Verify the quote request now shows:
   - Status: "견적서 발송됨" (green badge)
   - Button changed from "Create Quote" to "View Quote"

### 7. Test Korean Template
1. Click "Create Quote" on the Korean company (한국 반도체 주식회사)
2. Select **Korean Template**
3. Fill out similar details
4. Review and generate PDF
5. Verify Korean formatting in PDF

## 🔍 Where to Check Results

### Database
```bash
php artisan tinker
```
```php
// Check quote data
$quote = App\QuoteRequest::find(1);
echo $quote->status; // Should show 'quote_sent' after sending
print_r($quote->quote_data); // Shows JSON quote details
echo $quote->quote_pdf; // Shows PDF path
```

### Log File
Check email content in:
`storage/logs/laravel.log`

Look for sections containing:
- "Quote Request Received - ONCUBE GLOBAL"
- "New Quote Request - Test Company Ltd"
- "Quote for Your Inquiry - ONCUBE GLOBAL"
- "Quote Sent - Test Company Ltd"

### PDF Files
Check generated PDFs in:
`storage/app/quotes/`

Files will be named like: `quote_1_1732012345.pdf`

## 🎯 Expected Behavior

✅ Quote Builder should:
- Load customer info automatically
- Calculate item amounts in real-time
- Calculate totals automatically
- Validate required fields
- Save quote data as JSON

✅ Quote Review should:
- Display all quote information
- Show formatted preview
- Generate PDF on button click
- Send emails (logged to file)
- Update status to 'quote_sent'

✅ Email Notifications should:
- Send confirmation to customer when quote request is submitted
- Send alert to admin (kmmccc@gmail.com) when quote request is received
- Send quote to customer when admin sends it
- Send copy to admin when quote is sent

## 🐛 Troubleshooting

### Issue: "Create Quote" button not showing
- Check database migration ran: `php artisan migrate:status`
- Check quote_requests table has 'status' column

### Issue: Totals not calculating
- Check browser console for JavaScript errors
- Clear browser cache

### Issue: PDF generation fails
- Check dompdf is installed: `composer show barryvdh/laravel-dompdf`
- Check storage directory is writable
- Check logs: `storage/logs/laravel.log`

### Issue: Emails not logging
- Verify .env has `MAIL_MAILER=log`
- Run: `php artisan config:clear`
- Check `storage/logs/laravel.log` file exists and is writable

## 📊 Success Criteria

The quote system is working correctly if:

1. ✅ Quote requests display in admin panel with correct status badges
2. ✅ Quote Builder loads with pre-filled customer data
3. ✅ Dynamic line items add/remove/calculate correctly
4. ✅ Quote saves to database as JSON
5. ✅ Review page displays formatted quote
6. ✅ PDF generates successfully
7. ✅ Email content appears in log file
8. ✅ Status updates from 'pending' to 'quote_sent'
9. ✅ Action buttons change based on quote status
10. ✅ Both EN and KO templates work correctly
