@extends('layouts.email')

@section('title', '견적서 - 온큐브글로벌')

@section('content')
    <h2 style="margin-top:0;margin-bottom:20px;font-size:20px;line-height:28px;font-weight:bold;color:#002748;">
        {{ $quote->contact_name }}님께 보내는 견적서
    </h2>

    <p style="margin:0 0 15px 0;">{{ $quote->contact_name }}님, 안녕하세요.</p>

    <p style="margin:0 0 20px 0;">견적 문의 주셔서 감사합니다. 요청하신 내용에 대한 견적서를 첨부파일로 보내드립니다.</p>

    <div style="background-color:#f8f9fa;border-left:4px solid #19BD0A;padding:20px;margin-bottom:25px;border-radius:4px;">
        <table role="presentation" style="width:100%;border:none;border-spacing:0;">
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;width:120px;">견적서 번호:</td>
                <td style="padding-bottom:8px;color:#333;">{{ $quote->quote_data['quote_number'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:8px;font-weight:bold;color:#555;">발행일:</td>
                <td style="padding-bottom:8px;color:#333;">{{ isset($quote->quote_data['quote_date']) ? date('Y년 m월 d일', strtotime($quote->quote_data['quote_date'])) : date('Y년 m월 d일') }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;color:#555;">유효기간:</td>
                <td style="color:#333;">{{ isset($quote->quote_data['valid_until']) ? date('Y년 m월 d일', strtotime($quote->quote_data['valid_until'])) : 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <p style="margin:0 0 20px 0;">첨부된 PDF 견적서를 확인하시어 상세 가격 및 거래 조건을 검토해 주시기 바랍니다. 궁금하신 사항이 있거나 주문을 진행하고자 하시면 이 이메일에 회신 주시기 바랍니다.</p>

    <div style="text-align:center;margin:30px 0;">
        <a href="https://oncube.cloud" style="background-color:#002748;color:#ffffff;display:inline-block;font-family:Arial,sans-serif;font-size:16px;font-weight:bold;line-height:44px;text-align:center;text-decoration:none;width:200px;border-radius:4px;-webkit-text-size-adjust:none;">문의하기</a>
    </div>

    <p style="margin:0 0 10px 0;">고객님의 장비 구매에 최선을 다하겠습니다.</p>

    <p style="margin:0;">감사합니다.<br><strong>온큐브글로벌 드림</strong></p>
@endsection
