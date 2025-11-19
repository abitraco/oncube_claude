<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Quotation - {{ $data['quote_number'] }}</title>
    <style>
        @page {
            margin: 12mm 15mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            color: #2c3e50;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .header {
            background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
            padding: 12px 15px;
            margin-bottom: 12px;
            border-radius: 4px;
        }

        .header-flex {
            display: table;
            width: 100%;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 70%;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 30%;
        }

        .logo-box {
            background: white;
            padding: 6px 10px;
            border-radius: 3px;
            display: inline-block;
            margin-right: 12px;
            vertical-align: middle;
        }

        .logo-box img {
            width: 70px;
            height: auto;
            display: block;
        }

        .company-info {
            display: inline-block;
            vertical-align: middle;
            color: white;
        }

        .company-name {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .company-desc {
            font-size: 7.5pt;
            opacity: 0.9;
            line-height: 1.3;
        }

        .quote-title {
            color: white;
            font-size: 20pt;
            font-weight: bold;
            margin: 0 0 4px 0;
        }

        .quote-number {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
            display: inline-block;
        }

        .info-section {
            margin-bottom: 10px;
        }

        .info-row {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .info-cell {
            display: table-cell;
            width: 50%;
            padding: 0 5px;
        }

        .info-box {
            background: #f7fafc;
            border-left: 3px solid #2c5282;
            padding: 8px 12px;
            border-radius: 3px;
        }

        .info-box-title {
            color: #1e3a5f;
            font-size: 8.5pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .info-item {
            font-size: 8pt;
            margin: 3px 0;
            line-height: 1.3;
        }

        .info-label {
            color: #4a5568;
            font-weight: 600;
            display: inline-block;
            width: 75px;
        }

        .section-title {
            color: #1e3a5f;
            font-size: 10pt;
            font-weight: bold;
            margin: 12px 0 6px 0;
            padding-bottom: 4px;
            border-bottom: 2px solid #2c5282;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0;
        }

        .items-table th {
            background: #2c5282;
            color: white;
            padding: 6px 8px;
            text-align: left;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .items-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 8.5pt;
            background: white;
        }

        .items-table tbody tr:nth-child(even) td {
            background: #f7fafc;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            width: 280px;
            margin-left: auto;
            margin-top: 8px;
        }

        .total-row {
            padding: 5px 12px;
            background: #f7fafc;
            margin-bottom: 2px;
            border-radius: 2px;
        }

        .total-row table {
            width: 100%;
        }

        .total-label {
            font-weight: 600;
            color: #4a5568;
            font-size: 8.5pt;
        }

        .total-value {
            text-align: right;
            font-weight: bold;
            color: #2d3748;
            font-size: 8.5pt;
        }

        .grand-total {
            background: #1e3a5f;
            padding: 8px 12px;
            margin-top: 4px;
            border-radius: 3px;
        }

        .grand-total .total-label,
        .grand-total .total-value {
            color: white;
            font-size: 10pt;
        }

        .terms {
            margin-top: 12px;
            padding: 10px 12px;
            background: #fffaf0;
            border-left: 3px solid #ed8936;
            border-radius: 3px;
        }

        .terms-title {
            color: #1e3a5f;
            font-size: 9pt;
            font-weight: bold;
            margin: 0 0 6px 0;
        }

        .terms p {
            margin: 4px 0;
            font-size: 7.5pt;
            line-height: 1.4;
            color: #4a5568;
        }

        .terms strong {
            color: #2d3748;
            font-weight: 600;
        }

        .terms-notes {
            white-space: pre-wrap;
            font-size: 7.5pt;
            line-height: 1.4;
            margin-top: 4px;
        }

        .footer-note {
            margin-top: 6px;
            padding-top: 6px;
            border-top: 1px solid #e2e8f0;
            font-size: 6.5pt;
            color: #718096;
            line-height: 1.3;
        }

        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7pt;
            color: #a0aec0;
            padding: 6px 0;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-flex">
            <div class="header-left">
                <div class="logo-box">
                    <img src="{{ public_path('assets/logo.png') }}" alt="ONCUBE">
                </div>
                <div class="company-info">
                    <div class="company-name">ONCUBE GLOBAL</div>
                    <div class="company-desc">
                        Industrial & Semiconductor Equipment Distribution · Business Reg: 416-19-94501 · +82-10-4846-0846
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="quote-title">QUOTATION</div>
                <div class="quote-number">{{ $data['quote_number'] }}</div>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-row">
            <div class="info-cell">
                <div class="info-box">
                    <div class="info-box-title">Quote Information</div>
                    <div class="info-item"><span class="info-label">Quote No:</span> {{ $data['quote_number'] }}</div>
                    <div class="info-item"><span class="info-label">Quote Date:</span> {{ date('M d, Y', strtotime($data['quote_date'])) }}</div>
                    <div class="info-item"><span class="info-label">Valid Until:</span> {{ date('M d, Y', strtotime($data['valid_until'])) }}</div>
                </div>
            </div>
            <div class="info-cell">
                <div class="info-box">
                    <div class="info-box-title">Customer Information</div>
                    <div class="info-item"><span class="info-label">Company:</span> {{ $quote->company_name }}</div>
                    <div class="info-item"><span class="info-label">Contact:</span> {{ $quote->contact_name }}</div>
                    <div class="info-item"><span class="info-label">Email:</span> {{ $quote->company_email }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Section -->
    <div class="section-title">Line Items</div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 6%;" class="text-center">No.</th>
                <th style="width: 50%;">Description</th>
                <th style="width: 12%;" class="text-right">Quantity</th>
                <th style="width: 16%;" class="text-right">Unit Price (USD)</th>
                <th style="width: 16%;" class="text-right">Amount (USD)</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal = 0; @endphp
            @foreach($data['items'] as $index => $item)
            @php
                $amount = $item['quantity'] * $item['unit_price'];
                $subtotal += $amount;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item['description'] }}</td>
                <td class="text-right">{{ number_format($item['quantity']) }}</td>
                <td class="text-right">${{ number_format($item['unit_price'], 2) }}</td>
                <td class="text-right">${{ number_format($amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        <div class="total-row">
            <table>
                <tr>
                    <td class="total-label">Subtotal:</td>
                    <td class="total-value">${{ number_format($subtotal, 2) }}</td>
                </tr>
            </table>
        </div>
        <div class="total-row grand-total">
            <table>
                <tr>
                    <td class="total-label">Total Amount:</td>
                    <td class="total-value">${{ number_format($subtotal, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Terms -->
    <div class="terms">
        <div class="terms-title">Terms & Conditions</div>

        @if($data['payment_terms'])
        <p><strong>Payment:</strong> {{ $data['payment_terms'] }}</p>
        @endif

        @if($data['delivery_terms'])
        <p><strong>Delivery:</strong> {{ $data['delivery_terms'] }}</p>
        @endif

        @if($data['notes'])
        <p><strong>Additional Notes:</strong></p>
        <div class="terms-notes">{{ $data['notes'] }}</div>
        @endif

        <div class="footer-note">
            This quotation is valid until the expiry date mentioned above. All prices are in USD and exclude taxes unless otherwise specified.
        </div>
    </div>

    <!-- Footer -->
    <div class="page-footer">
        ONCUBE GLOBAL · +82-10-4846-0846 · Business Registration: 416-19-94501 · Issue Date: {{ date('M d, Y') }}
    </div>
</body>
</html>
