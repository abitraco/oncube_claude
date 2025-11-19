<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <title>견적서 - {{ $data['quote_number'] }}</title>
    <style>
        @page {
            margin: 20mm;
        }

        body {
            font-family: 'DejaVu Sans', 'Malgun Gothic', sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.6;
        }

        .header {
            background: #002748;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 5px;
        }

        .header-container {
            width: 100%;
        }

        .header-top {
            display: table;
            width: 100%;
            margin-bottom: 0;
        }

        .header-logo {
            display: table-cell;
            width: 120px;
            vertical-align: middle;
            background: white;
            padding: 10px;
            border-radius: 5px;
        }

        .header-logo img {
            width: 100px;
            height: auto;
            display: block;
        }

        .header-company {
            display: table-cell;
            vertical-align: middle;
            padding-left: 20px;
            color: white;
        }

        .company-title {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .company-desc {
            font-size: 9pt;
            line-height: 1.4;
        }

        .header-right {
            text-align: right;
            color: white;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        .header-right h1 {
            font-size: 28pt;
            margin: 0 0 5px 0;
            color: white;
            font-weight: bold;
        }

        .quote-number-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 5px 12px;
            border-radius: 3px;
            font-size: 11pt;
            font-weight: bold;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
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
            border-left: 4px solid #002748;
            padding: 12px 15px;
            background: #f8f9fa;
            border-radius: 3px;
            margin-bottom: 10px;
        }

        .info-box h4 {
            margin: 0 0 12px 0;
            color: #002748;
            font-size: 10pt;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .info-box p {
            margin: 6px 0;
            font-size: 9.5pt;
            line-height: 1.5;
        }

        .info-box p strong {
            color: #002748;
            font-weight: bold;
            display: inline-block;
            min-width: 90px;
        }

        .items-section-title {
            color: #002748;
            font-size: 13pt;
            font-weight: bold;
            margin: 25px 0 12px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            border-radius: 5px;
            overflow: hidden;
        }

        .items-table th {
            background: #002748;
            color: white;
            padding: 12px 10px;
            text-align: left;
            font-size: 9.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #e9ecef;
            font-size: 9.5pt;
            background: white;
        }

        .items-table tbody tr:nth-child(even) td {
            background: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            width: 320px;
            margin-left: auto;
            margin-top: 20px;
        }

        .total-row {
            padding: 10px 15px;
            background: #f8f9fa;
            margin-bottom: 2px;
        }

        .total-row table {
            width: 100%;
        }

        .total-label {
            font-weight: bold;
            color: #555;
            font-size: 10pt;
        }

        .total-value {
            text-align: right;
            font-weight: bold;
            color: #333;
            font-size: 10pt;
        }

        .total-row.grand-total {
            background: #002748;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            padding: 14px 15px;
            margin-top: 8px;
        }

        .grand-total .total-label,
        .grand-total .total-value {
            color: white;
            font-size: 12pt;
        }

        .terms {
            margin-top: 30px;
            padding: 18px 20px;
            background: #f8f9fa;
            border-left: 4px solid #FF6B00;
            border-radius: 3px;
            page-break-inside: avoid;
        }

        .terms h4 {
            margin: 0 0 15px 0;
            color: #002748;
            font-size: 12pt;
            font-weight: bold;
        }

        .terms p {
            margin: 8px 0;
            font-size: 9pt;
            line-height: 1.6;
            color: #555;
        }

        .terms p strong {
            color: #002748;
            font-weight: bold;
        }

        .terms .notes {
            white-space: pre-wrap;
            font-size: 9pt;
            line-height: 1.6;
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
    <div class="header">
        <div class="header-container">
            <div class="header-top">
                <div class="header-logo">
                    <img src="{{ public_path('assets/logo.png') }}" alt="ONCUBE GLOBAL">
                </div>
                <div class="header-company">
                    <div class="company-title">ONCUBE GLOBAL</div>
                    <div class="company-desc">
                        산업용 기계 및 반도체 장비 유통<br>
                        사업자등록번호: 416-19-94501 | 연락처: +82-10-4846-0846
                    </div>
                </div>
            </div>
            <div class="header-right">
                <h1>견적서</h1>
                <span class="quote-number-badge">{{ $data['quote_number'] }}</span>
            </div>
        </div>
    </div>

    <div class="quote-info">
        <table>
            <tr>
                <td style="width: 50%;">
                    <div class="info-box">
                        <h4>견적 정보</h4>
                        <p><strong>견적 번호:</strong> {{ $data['quote_number'] }}</p>
                        <p><strong>견적일:</strong> {{ date('Y년 m월 d일', strtotime($data['quote_date'])) }}</p>
                        <p><strong>유효 기간:</strong> {{ date('Y년 m월 d일', strtotime($data['valid_until'])) }}</p>
                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="info-box">
                        <h4>고객 정보</h4>
                        <p><strong>회사명:</strong> {{ $quote->company_name }}</p>
                        <p><strong>담당자:</strong> {{ $quote->contact_name }}</p>
                        <p><strong>이메일:</strong> {{ $quote->company_email }}</p>
                        <p><strong>전화번호:</strong> {{ $quote->phone }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <h3 class="items-section-title">📋 품목 내역</h3>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 8%;" class="text-center">번호</th>
                <th style="width: 45%;">품명 및 규격</th>
                <th style="width: 12%;" class="text-right">수량</th>
                <th style="width: 15%;" class="text-right">단가 (USD)</th>
                <th style="width: 20%;" class="text-right">금액 (USD)</th>
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
            <table>
                <tr>
                    <td class="total-label">소계:</td>
                    <td class="total-value">${{ number_format($subtotal, 2) }}</td>
                </tr>
            </table>
        </div>
        <div class="total-row grand-total">
            <table>
                <tr>
                    <td class="total-label">합계 금액:</td>
                    <td class="total-value">${{ number_format($subtotal, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="terms">
        <h4>거래 조건</h4>

        @if($data['payment_terms'])
        <p><strong>결제 조건:</strong> {{ $data['payment_terms'] }}</p>
        @endif

        @if($data['delivery_terms'])
        <p><strong>인도 조건:</strong> {{ $data['delivery_terms'] }}</p>
        @endif

        @if($data['notes'])
        <p><strong>추가 사항:</strong></p>
        <div class="notes">{{ $data['notes'] }}</div>
        @endif

        <p style="margin-top: 15px; font-size: 8pt; color: #666;">
            본 견적서는 상기 유효기간 동안 유효합니다. 모든 가격은 미화(USD) 기준이며, 별도 명시가 없는 한 세금은 포함되지 않습니다.
        </p>
    </div>

    <div class="footer">
        온큐브글로벌 (ONCUBE GLOBAL) | +82-10-4846-0846 | 사업자등록번호: 416-19-94501<br>
        발행일: {{ date('Y년 m월 d일') }}
    </div>
</body>
</html>
