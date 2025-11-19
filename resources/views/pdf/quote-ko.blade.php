<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>견적서 - {{ $data['quote_number'] }}</title>
    <style>
        @page {
            margin: 8mm 10mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .document-border {
            border: 3px solid #003d6b;
            border-radius: 8px;
            padding: 0;
            min-height: 270mm;
        }

        .header {
            background: linear-gradient(135deg, #003d6b 0%, #0056a3 100%);
            padding: 20px 25px;
            border-radius: 6px 6px 0 0;
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
            padding: 8px 12px;
            border-radius: 6px;
            display: inline-block;
            margin-right: 15px;
            vertical-align: middle;
        }

        .logo-box img {
            width: 110px;
            height: auto;
            display: block;
        }

        .company-info {
            display: inline-block;
            vertical-align: middle;
            color: white;
        }

        .company-name {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .company-desc {
            font-size: 7.5pt;
            opacity: 0.95;
            line-height: 1.4;
        }

        .quote-title {
            color: white;
            font-size: 26pt;
            font-weight: bold;
            margin: 0 0 6px 0;
            letter-spacing: 8px;
        }

        .quote-number {
            background: rgba(255,255,255,0.25);
            color: white;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 9.5pt;
            font-weight: bold;
            display: inline-block;
        }

        .content-area {
            padding: 22px 25px;
        }

        .info-section {
            margin-bottom: 15px;
        }

        .info-row {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3px;
        }

        .info-cell {
            display: table-cell;
            width: 50%;
            padding: 0 8px 0 0;
        }

        .info-cell:last-child {
            padding: 0 0 0 8px;
        }

        .info-box {
            background: #f8f9fa;
            border: 1px solid #d8d8d8;
            border-left: 4px solid #003d6b;
            padding: 12px 16px;
            border-radius: 6px;
        }

        .info-box-title {
            color: #003d6b;
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item {
            font-size: 8.5pt;
            margin: 4px 0;
            line-height: 1.4;
            color: #555;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .info-label {
            color: #003d6b;
            font-weight: 600;
            display: inline-block;
            width: 75px;
            vertical-align: top;
        }

        .info-value {
            display: inline;
            word-break: break-word;
            font-size: 8pt;
        }

        .section-header {
            background: #f0f4f8;
            padding: 8px 12px;
            margin: 18px 0 8px 0;
            border-left: 5px solid #FF6B00;
            border-radius: 6px;
        }

        .section-header-icon {
            display: inline-block;
            margin-right: 8px;
            font-size: 11pt;
        }

        .section-header-text {
            color: #003d6b;
            font-size: 10pt;
            font-weight: bold;
            display: inline-block;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            border: 1px solid #c8c8c8;
        }

        .items-table th {
            background: #003d6b;
            color: white;
            padding: 9px 12px;
            text-align: left;
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #002847;
        }

        .items-table td {
            padding: 9px 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 9pt;
            background: white;
        }

        .items-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals-area {
            margin-top: 12px;
            text-align: right;
        }

        .totals {
            display: inline-block;
            min-width: 280px;
            border: 1px solid #c8c8c8;
            border-radius: 6px;
            overflow: hidden;
        }

        .total-row {
            padding: 8px 16px;
            background: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
        }

        .total-row:last-child {
            border-bottom: none;
        }

        .total-row table {
            width: 100%;
        }

        .total-label {
            font-weight: 600;
            color: #555;
            font-size: 9pt;
        }

        .total-value {
            text-align: right;
            font-weight: bold;
            color: #333;
            font-size: 9pt;
        }

        .grand-total {
            background: #003d6b;
            padding: 10px 16px;
        }

        .grand-total .total-label,
        .grand-total .total-value {
            color: white;
            font-size: 11pt;
        }

        .terms {
            margin-top: 16px;
            padding: 14px 16px;
            background: #fffbf5;
            border: 1px solid #ffe0b2;
            border-left: 4px solid #FF6B00;
            border-radius: 6px;
        }

        .terms-title {
            background: #fff;
            padding: 5px 10px;
            border-left: 4px solid #FF6B00;
            margin-bottom: 10px;
            display: inline-block;
        }

        .terms-title-icon {
            display: inline-block;
            margin-right: 6px;
            font-size: 10pt;
        }

        .terms-title-text {
            color: #003d6b;
            font-size: 9.5pt;
            font-weight: bold;
            display: inline-block;
        }

        .terms p {
            margin: 6px 0;
            font-size: 8.5pt;
            line-height: 1.6;
            color: #555;
        }

        .terms strong {
            color: #003d6b;
            font-weight: 600;
        }

        .terms-notes {
            white-space: pre-wrap;
            font-size: 8.5pt;
            line-height: 1.6;
            margin-top: 5px;
            color: #555;
        }

        .footer-note {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #d8d8d8;
            font-size: 7.5pt;
            color: #888;
            line-height: 1.5;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="document-border">
        <!-- Header -->
        <div class="header">
            <div class="header-flex">
                <div class="header-left">
                    <div class="logo-box">
                        <img src="{{ public_path('assets/logo.png') }}" alt="ONCUBE">
                    </div>
                    <div class="company-info">
                        <div class="company-name">온큐브글로벌 (ONCUBE GLOBAL)</div>
                        <div class="company-desc">
                            산업용 기계 및 반도체 장비 유통<br>
                            사업자등록번호: 416-19-94501 | 연락처: +82-10-4846-0846
                        </div>
                    </div>
                </div>
                <div class="header-right">
                    <div class="quote-title">견 적 서</div>
                    <div class="quote-number">{{ $data['quote_number'] }}</div>
                </div>
            </div>
        </div>

        <div class="content-area">
            <!-- Info Section -->
            <div class="info-section">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-box">
                            <div class="info-box-title">QUOTE INFORMATION</div>
                            <div class="info-item">
                                <span class="info-label">Quote Number:</span><span class="info-value">{{ $data['quote_number'] }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Date:</span><span class="info-value">{{ date('F d, Y', strtotime($data['quote_date'])) }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Valid Until:</span><span class="info-value">{{ date('F d, Y', strtotime($data['valid_until'])) }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Template:</span><span class="info-value">Korean</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-cell">
                        <div class="info-box">
                            <div class="info-box-title">CUSTOMER INFORMATION</div>
                            <div class="info-item">
                                <span class="info-label">Company:</span><span class="info-value">{{ $quote->company_name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Contact:</span><span class="info-value">{{ $quote->contact_name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email:</span><span class="info-value">{{ $quote->company_email }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Phone:</span><span class="info-value">{{ $quote->phone }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Section -->
            <div class="section-header">
                <span class="section-header-icon">📋</span>
                <span class="section-header-text">Line Items</span>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 5%;" class="text-center">#</th>
                        <th style="width: 48%;">DESCRIPTION</th>
                        <th style="width: 12%;" class="text-right">QUANTITY</th>
                        <th style="width: 17%;" class="text-right">UNIT PRICE</th>
                        <th style="width: 18%;" class="text-right">AMOUNT</th>
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
            <div class="totals-area">
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
            </div>

            <!-- Terms -->
            <div class="terms">
                <div class="terms-title">
                    <span class="terms-title-icon">📝</span>
                    <span class="terms-title-text">Terms & Conditions</span>
                </div>

                @if($data['payment_terms'])
                <p><strong>Payment Terms:</strong> {{ $data['payment_terms'] }}</p>
                @endif

                @if($data['delivery_terms'])
                <p><strong>Delivery Terms:</strong> {{ $data['delivery_terms'] }}</p>
                @endif

                @if($data['notes'])
                <p><strong>Notes:</strong></p>
                <div class="terms-notes">{{ $data['notes'] }}</div>
                @endif

                <div class="footer-note">
                    This quotation is valid until the expiry date mentioned above. All prices are in USD and exclude taxes unless otherwise specified.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
