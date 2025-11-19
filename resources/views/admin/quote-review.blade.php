<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Review Quote - Admin Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }

        h1 {
            color: #333;
            font-size: 28px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #002748;
            color: white;
        }

        .btn-success {
            background: #19BD0A;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-warning {
            background: #FF6B00;
            color: white;
        }

        .quote-preview {
            border: 2px solid #002748;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 30px;
            background: white;
        }

        .quote-header {
            margin-bottom: 30px;
            padding: 25px;
            background: linear-gradient(135deg, #002748 0%, #004080 100%);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .quote-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .quote-header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 1;
        }

        .quote-header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .quote-header-logo {
            background: white;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quote-header-logo img {
            width: 100px;
            height: auto;
            display: block;
        }

        .quote-header-company {
            color: white;
        }

        .quote-header-company .company-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .quote-header-company .company-desc {
            font-size: 12px;
            opacity: 0.9;
            line-height: 1.5;
        }

        .quote-header-right {
            text-align: right;
            color: white;
        }

        .quote-header-right h2 {
            font-size: 38px;
            font-weight: 700;
            margin: 0 0 8px 0;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .quote-header-right .quote-number {
            font-size: 14px;
            font-weight: 500;
            opacity: 0.95;
            background: rgba(255,255,255,0.1);
            padding: 6px 12px;
            border-radius: 4px;
            display: inline-block;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .quote-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 25px 0;
        }

        .info-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #002748;
        }

        .info-section h4 {
            color: #002748;
            margin-bottom: 15px;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .info-section p {
            margin: 8px 0;
            color: #555;
            font-size: 14px;
            line-height: 1.6;
        }

        .info-section p strong {
            color: #002748;
            font-weight: 600;
            min-width: 110px;
            display: inline-block;
        }

        .items-section {
            margin-top: 30px;
        }

        .items-section h4 {
            color: #002748;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .items-section h4::before {
            content: '📋';
            font-size: 20px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        .items-table th {
            background: linear-gradient(135deg, #002748 0%, #003d6b 100%);
            color: white;
            font-weight: 600;
            padding: 15px 12px;
            text-align: left;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #e9ecef;
            background: white;
        }

        .items-table tbody tr:hover {
            background: #f8f9fa;
            transition: background 0.2s ease;
        }

        .items-table tbody tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            margin-top: 25px;
            padding: 0;
            background: transparent;
        }

        .total-row {
            display: flex;
            justify-content: flex-end;
            gap: 40px;
            padding: 12px 20px;
            background: #f8f9fa;
            margin-bottom: 2px;
        }

        .total-label {
            font-weight: 600;
            min-width: 150px;
            color: #555;
        }

        .total-value {
            min-width: 140px;
            text-align: right;
            font-weight: 600;
            color: #333;
        }

        .grand-total {
            background: linear-gradient(135deg, #002748 0%, #003d6b 100%);
            color: white;
            font-size: 18px;
            font-weight: 700;
            border-radius: 8px;
            padding: 18px 20px;
            margin-top: 8px;
            box-shadow: 0 4px 6px rgba(0,39,72,0.2);
        }

        .grand-total .total-label,
        .grand-total .total-value {
            color: white;
        }

        .terms-section {
            margin-top: 35px;
            padding: 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            border-left: 4px solid #FF6B00;
        }

        .terms-section h4 {
            color: #002748;
            margin-bottom: 18px;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .terms-section h4::before {
            content: '📝';
            font-size: 20px;
        }

        .terms-section p {
            margin: 10px 0;
            color: #555;
            font-size: 14px;
            line-height: 1.7;
        }

        .terms-section p strong {
            color: #002748;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: space-between;
            margin-top: 30px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        #pdfPreview {
            width: 100%;
            height: 800px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Review & Send Quote</h1>
            <a href="{{ route('admin.quotes') }}" class="btn btn-secondary">Back to Quotes</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @php
            $data = $quoteRequest->quote_data;
            $subtotal = 0;
            foreach ($data['items'] as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }
        @endphp

        <!-- Quote Preview -->
        <div class="quote-preview">
            <div class="quote-header">
                <div class="quote-header-container">
                    <div class="quote-header-left">
                        <div class="quote-header-logo">
                            <img src="{{ asset('assets/logo.png') }}" alt="ONCUBE GLOBAL">
                        </div>
                        <div class="quote-header-company">
                            <div class="company-title">
                                {{ $quoteRequest->quote_template == 'ko' ? '온큐브글로벌 (ONCUBE GLOBAL)' : 'ONCUBE GLOBAL' }}
                            </div>
                            <div class="company-desc">
                                {{ $quoteRequest->quote_template == 'ko' ? '산업용 기계 및 반도체 장비 유통' : 'Industrial & Semiconductor Equipment Distribution' }}<br>
                                {{ $quoteRequest->quote_template == 'ko' ? '사업자등록번호: 416-19-94501 | 연락처: +82-10-4846-0846' : 'License: 416-19-94501 | Tel: +82-10-4846-0846' }}
                            </div>
                        </div>
                    </div>
                    <div class="quote-header-right">
                        <h2>{{ $quoteRequest->quote_template == 'ko' ? '견 적 서' : 'QUOTATION' }}</h2>
                        <div class="quote-number">{{ $data['quote_number'] }}</div>
                    </div>
                </div>
            </div>

            <div class="quote-info">
                <div class="info-section">
                    <h4>Quote Information</h4>
                    <p><strong>Quote Number:</strong> {{ $data['quote_number'] }}</p>
                    <p><strong>Date:</strong> {{ date('F d, Y', strtotime($data['quote_date'])) }}</p>
                    <p><strong>Valid Until:</strong> {{ date('F d, Y', strtotime($data['valid_until'])) }}</p>
                    <p><strong>Template:</strong> {{ $quoteRequest->quote_template == 'en' ? 'English' : 'Korean' }}</p>
                </div>

                <div class="info-section">
                    <h4>Customer Information</h4>
                    <p><strong>Company:</strong> {{ $quoteRequest->company_name }}</p>
                    <p><strong>Contact:</strong> {{ $quoteRequest->contact_name }}</p>
                    <p><strong>Email:</strong> {{ $quoteRequest->company_email }}</p>
                    <p><strong>Phone:</strong> {{ $quoteRequest->phone }}</p>
                </div>
            </div>

            <div class="items-section">
                <h4>Line Items</h4>
                <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 45%">Description</th>
                        <th style="width: 15%" class="text-right">Quantity</th>
                        <th style="width: 15%" class="text-right">Unit Price</th>
                        <th style="width: 20%" class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['items'] as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['description'] }}</td>
                        <td class="text-right">{{ number_format($item['quantity']) }}</td>
                        <td class="text-right">${{ number_format($item['unit_price'], 2) }}</td>
                        <td class="text-right">${{ number_format($item['quantity'] * $item['unit_price'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>

                <div class="totals">
                <div class="total-row">
                    <span class="total-label">Subtotal:</span>
                    <span class="total-value">${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="total-row grand-total">
                    <span class="total-label">Total Amount:</span>
                    <span class="total-value">${{ number_format($subtotal, 2) }}</span>
                </div>
                </div>
            </div>

            @if($data['payment_terms'] || $data['delivery_terms'] || $data['notes'])
            <div class="terms-section">
                <h4>Terms & Conditions</h4>
                @if($data['payment_terms'])
                    <p><strong>Payment Terms:</strong> {{ $data['payment_terms'] }}</p>
                @endif
                @if($data['delivery_terms'])
                    <p><strong>Delivery Terms:</strong> {{ $data['delivery_terms'] }}</p>
                @endif
                @if($data['notes'])
                    <p><strong>Notes:</strong></p>
                    <p style="white-space: pre-wrap;">{{ $data['notes'] }}</p>
                @endif
            </div>
            @endif
        </div>

        <!-- PDF Preview (if generated) -->
        @if($quoteRequest->quote_pdf)
        <div style="margin: 30px 0;">
            <h3 style="margin-bottom: 15px;">PDF Preview</h3>
            <iframe id="pdfPreview" src="{{ asset('storage/' . $quoteRequest->quote_pdf) }}"></iframe>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
            <div>
                <a href="{{ route('admin.quote.builder', $quoteRequest->id) }}" class="btn btn-warning">
                    Edit Quote
                </a>
            </div>
            <div style="display: flex; gap: 15px;">
                <button type="button" class="btn btn-primary" onclick="generatePDF()">
                    {{ $quoteRequest->quote_pdf ? 'Regenerate PDF' : 'Generate PDF' }}
                </button>
                @if($quoteRequest->quote_pdf)
                <form action="{{ route('admin.quote.send', $quoteRequest->id) }}" method="POST" style="display: inline;"
                      onsubmit="return confirm('Send quote to {{ $quoteRequest->company_email }}?')">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        Send Quote via Email
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        function generatePDF() {
            if (!confirm('Generate PDF from this quote?')) return;

            fetch('{{ route("admin.quote.generate-pdf", $quoteRequest->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('PDF generated successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + (data.error || 'Failed to generate PDF'));
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        }
    </script>
</body>
</html>
