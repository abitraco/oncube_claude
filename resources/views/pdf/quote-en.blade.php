<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation - {{ $data['quote_number'] }}</title>
    <style>
        @page {
            margin: 20mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.6;
        }

        .header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #002748;
            position: relative;
        }

        .header-logo {
            float: left;
            width: 150px;
            margin-right: 20px;
        }

        .header-logo img {
            max-width: 150px;
            height: auto;
        }

        .header-content {
            text-align: center;
            padding-top: 10px;
        }

        .header h1 {
            color: #002748;
            font-size: 32pt;
            margin: 0 0 10px 0;
        }

        .company-name {
            font-size: 14pt;
            color: #666;
            margin: 5px 0;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .company-info {
            font-size: 9pt;
            color: #888;
        }

        .quote-info {
            width: 100%;
            margin-bottom: 20px;
        }

        .quote-info table {
            width: 100%;
        }

        .quote-info td {
            vertical-align: top;
            padding: 10px;
        }

        .info-box {
            border: 1px solid #ddd;
            padding: 15px;
            background: #f9f9f9;
        }

        .info-box h4 {
            margin: 0 0 10px 0;
            color: #002748;
            font-size: 11pt;
            text-transform: uppercase;
            border-bottom: 1px solid #002748;
            padding-bottom: 5px;
        }

        .info-box p {
            margin: 5px 0;
            font-size: 10pt;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th {
            background: #002748;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 10pt;
        }

        .items-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
            font-size: 10pt;
        }

        .items-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            width: 300px;
            margin-left: auto;
            margin-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 15px;
            border-bottom: 1px solid #ddd;
        }

        .total-row.grand-total {
            background: #002748;
            color: white;
            font-weight: bold;
            font-size: 14pt;
            border-bottom: none;
        }

        .terms {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            page-break-inside: avoid;
        }

        .terms h4 {
            margin: 0 0 15px 0;
            color: #002748;
            font-size: 12pt;
            border-bottom: 2px solid #002748;
            padding-bottom: 5px;
        }

        .terms p {
            margin: 10px 0;
            font-size: 9pt;
        }

        .terms .notes {
            white-space: pre-wrap;
            font-size: 9pt;
            line-height: 1.5;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        strong {
            color: #002748;
        }
    </style>
</head>
<body>
    <div class="header clearfix">
        <div class="header-logo">
            <img src="{{ public_path('assets/logo.png') }}" alt="ONCUBE GLOBAL">
        </div>
        <div class="header-content">
            <h1>QUOTATION</h1>
            <div class="company-name">ONCUBE GLOBAL</div>
            <div class="company-info">
                Industrial & Semiconductor Equipment Distribution<br>
                License: 416-19-94501 | Tel: +82-10-4846-0846
            </div>
        </div>
    </div>

    <div class="quote-info">
        <table>
            <tr>
                <td style="width: 50%;">
                    <div class="info-box">
                        <h4>Quote Information</h4>
                        <p><strong>Quote Number:</strong> {{ $data['quote_number'] }}</p>
                        <p><strong>Date:</strong> {{ date('F d, Y', strtotime($data['quote_date'])) }}</p>
                        <p><strong>Valid Until:</strong> {{ date('F d, Y', strtotime($data['valid_until'])) }}</p>
                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="info-box">
                        <h4>Customer Information</h4>
                        <p><strong>Company:</strong> {{ $quote->company_name }}</p>
                        <p><strong>Contact:</strong> {{ $quote->contact_name }}</p>
                        <p><strong>Email:</strong> {{ $quote->company_email }}</p>
                        <p><strong>Phone:</strong> {{ $quote->phone }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <h3 style="color: #002748; margin: 30px 0 10px 0;">Line Items</h3>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 8%;" class="text-center">#</th>
                <th style="width: 45%;">Description</th>
                <th style="width: 12%;" class="text-right">Quantity</th>
                <th style="width: 15%;" class="text-right">Unit Price</th>
                <th style="width: 20%;" class="text-right">Amount (USD)</th>
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

    <div class="totals">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>${{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="total-row grand-total">
            <span>Total Amount:</span>
            <span>${{ number_format($subtotal, 2) }}</span>
        </div>
    </div>

    <div class="terms">
        <h4>Terms & Conditions</h4>

        @if($data['payment_terms'])
        <p><strong>Payment Terms:</strong> {{ $data['payment_terms'] }}</p>
        @endif

        @if($data['delivery_terms'])
        <p><strong>Delivery Terms:</strong> {{ $data['delivery_terms'] }}</p>
        @endif

        @if($data['notes'])
        <p><strong>Additional Notes:</strong></p>
        <div class="notes">{{ $data['notes'] }}</div>
        @endif

        <p style="margin-top: 15px; font-size: 8pt; color: #666;">
            This quotation is valid for the period specified above. All prices are in USD and exclude applicable taxes unless otherwise stated.
        </p>
    </div>

    <div class="footer">
        ONCUBE GLOBAL | +82-10-4846-0846 | License: 416-19-94501<br>
        Generated on {{ date('F d, Y') }}
    </div>
</body>
</html>
