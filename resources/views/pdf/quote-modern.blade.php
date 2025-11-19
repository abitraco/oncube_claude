<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 10mm;
            margin-top: 10mm;
            margin-bottom: 10mm;
        }
        body {
            font-family: 'malgun', 'AppleGothic', 'Dotum', sans-serif;
            color: #333;
            font-size: 9pt;
            line-height: 1.4;
        }
        
        /* Header */
        .header-container {
            background-color: #002748;
            color: #ffffff;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .header-content {
            width: 100%;
        }
        .logo-area {
            width: 60%;
            vertical-align: middle;
        }
        .title-area {
            width: 40%;
            text-align: right;
            vertical-align: middle;
            color: #ffffff;
        }
        .company-name {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
            color: #ffffff;
        }
        .company-sub {
            font-size: 9pt;
            opacity: 0.9;
            color: #ffffff;
        }
        .quote-title {
            font-size: 28pt;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 5px;
            color: #ffffff;
        }
        .quote-badge {
            background-color: rgba(255,255,255,0.15);
            color: #ffffff;
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 10pt;
            display: inline-block;
        }

        /* Info Cards */
        .info-container {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-card {
            background-color: #f0f2f5;
            border-radius: 8px;
            padding: 20px;
            border-left: 4px solid #002748;
        }
        .info-title {
            color: #002748;
            font-weight: bold;
            font-size: 9pt;
            text-transform: uppercase;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 5px;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            width: 100px;
            display: inline-block;
        }
        .info-value {
            color: #333;
        }

        /* Line Items */
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            color: #002748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            border-bottom: 2px solid #002748;
            padding-bottom: 5px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 10px;
            border-radius: 8px 8px 0 0;
            overflow: hidden;
        }
        .items-table th {
            background-color: #002748;
            color: #ffffff;
            padding: 12px 15px;
            text-align: left;
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .items-table tr:last-child td {
            border-bottom: none;
        }
        .items-table tr:nth-child(even) {
            background-color: #fcfcfc;
        }
        .col-num { width: 5%; text-align: center; }
        .col-desc { width: 55%; }
        .col-qty { width: 10%; text-align: center; }
        .col-price { width: 15%; text-align: right; }
        .col-amount { width: 15%; text-align: right; }

        /* Totals */
        .totals-container {
            width: 100%;
            margin-bottom: 30px;
        }
        .subtotal-row {
            text-align: right;
            padding: 10px 15px;
            background-color: #f0f2f5;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .total-row {
            background-color: #002748;
            color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            text-align: right;
            font-size: 11pt;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .total-label {
            margin-right: 20px;
            color: #ffffff;
        }

        /* Terms */
        .terms-card {
            background-color: #f0f2f5;
            border-radius: 8px;
            padding: 20px;
            border-left: 4px solid #ff6b00;
        }
        .terms-item {
            margin-bottom: 8px;
        }
        .terms-label {
            font-weight: bold;
            color: #002748;
            margin-right: 5px;
        }
        
        /* Utilities */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .mt-20 { margin-top: 20px; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header-container">
        <table class="header-content">
            <tr>
                <td class="logo-area">
                    <div style="background-color: white; padding: 10px; border-radius: 4px; display: inline-block; margin-bottom: 10px;">
                        <img src="{{ public_path('assets/logo.png') }}" style="height: 30px;">
                    </div>
                    <div class="company-name">온큐브글로벌 (ONCUBE GLOBAL)</div>
                    <div class="company-sub">
                        산업용 기계 및 반도체 장비 유통<br>
                        사업자등록번호: 416-19-94501 | 연락처: +82-10-4846-0846
                    </div>
                </td>
                <td class="title-area">
                    <div class="quote-title">견 적 서</div>
                    <div class="quote-badge">{{ $data['quote_number'] }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Info Cards -->
    <table class="info-container" cellspacing="0" cellpadding="0" style="border-spacing: 15px 0; margin-left: -15px; margin-right: -15px; width: 104%;">
        <tr>
            <td width="50%" valign="top">
                <div class="info-card">
                    <div class="info-title">QUOTE INFORMATION</div>
                    <table width="100%">
                        <tr>
                            <td class="info-label">Quote Number:</td>
                            <td class="info-value">{{ $data['quote_number'] }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Date:</td>
                            <td class="info-value">{{ \Carbon\Carbon::parse($data['quote_date'])->format('F d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Valid Until:</td>
                            <td class="info-value">{{ \Carbon\Carbon::parse($data['valid_until'])->format('F d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Template:</td>
                            <td class="info-value">{{ $data['quote_template'] == 'ko' ? 'Korean' : 'English' }}</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td width="50%" valign="top">
                <div class="info-card">
                    <div class="info-title">CUSTOMER INFORMATION</div>
                    <table width="100%">
                        <tr>
                            <td class="info-label">Company:</td>
                            <td class="info-value">{{ $quote->company_name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Contact:</td>
                            <td class="info-value">{{ $quote->contact_name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Email:</td>
                            <td class="info-value">{{ $quote->company_email }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Phone:</td>
                            <td class="info-value">{{ $quote->phone }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <!-- Line Items -->
    <div class="section-title">
        Line Items
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th class="col-num">#</th>
                <th class="col-desc">DESCRIPTION</th>
                <th class="col-qty">QUANTITY</th>
                <th class="col-price">UNIT PRICE</th>
                <th class="col-amount">AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($data['items'] as $index => $item)
            @php 
                $amount = $item['quantity'] * $item['unit_price'];
                $total += $amount;
            @endphp
            <tr>
                <td class="col-num">{{ $index + 1 }}</td>
                <td class="col-desc">{{ $item['description'] }}</td>
                <td class="col-qty">{{ $item['quantity'] }}</td>
                <td class="col-price">${{ number_format($item['unit_price'], 2) }}</td>
                <td class="col-amount">${{ number_format($amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals-container">
        <div class="subtotal-row">
            <span style="font-weight: bold; color: #555; margin-right: 20px;">Subtotal:</span>
            <span style="font-weight: bold; color: #333;">${{ number_format($total, 2) }}</span>
        </div>
        <div class="total-row">
            <span class="total-label">Total Amount:</span>
            <span style="color: #ffffff;">${{ number_format($total, 2) }}</span>
        </div>
    </div>

    <!-- Terms -->
    <div class="section-title">
        Terms & Conditions
    </div>
    
    <div class="terms-card">
        @if(!empty($data['payment_terms']))
        <div class="terms-item">
            <span class="terms-label">Payment Terms:</span> {{ $data['payment_terms'] }}
        </div>
        @endif
        
        @if(!empty($data['delivery_terms']))
        <div class="terms-item">
            <span class="terms-label">Delivery Terms:</span> {{ $data['delivery_terms'] }}
        </div>
        @endif

        @if(!empty($data['notes']))
        <div class="terms-item" style="margin-top: 15px;">
            <span class="terms-label">Notes:</span><br>
            <div style="margin-top: 5px; white-space: pre-line;">{{ $data['notes'] }}</div>
        </div>
        @endif
        
        <div style="margin-top: 15px; font-size: 8pt; color: #666; border-top: 1px solid #eee; padding-top: 10px;">
            Price is subject to change without notice.<br>
            Lead time: 2-4 weeks after order confirmation.<br>
            Warranty: 12 months from delivery date.
        </div>
    </div>

</body>
</html>