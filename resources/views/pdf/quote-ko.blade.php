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
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #002748;
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
            text-align: center;
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
    <div class="header">
        <h1>견 적 서</h1>
        <div class="company-name">온큐브글로벌 (ONCUBE GLOBAL)</div>
        <div class="company-info">
            산업용 기계 및 반도체 장비 유통<br>
            사업자등록번호: 416-19-94501 | 연락처: +82-10-4846-0846
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

    <h3 style="color: #002748; margin: 30px 0 10px 0;">품목 내역</h3>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 8%;">번호</th>
                <th style="width: 45%;">품명 및 규격</th>
                <th style="width: 12%;">수량</th>
                <th style="width: 15%;">단가 (USD)</th>
                <th style="width: 20%;">금액 (USD)</th>
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
            <span>소계:</span>
            <span>${{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="total-row grand-total">
            <span>합계 금액:</span>
            <span>${{ number_format($subtotal, 2) }}</span>
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
