@extends('layouts.admin')

@section('title', 'Review Quote')
@section('header_title', 'Review & Send Quote')

@section('styles')
<style>
    .quote-preview {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 40px;
        margin-bottom: 30px;
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .quote-header {
        margin-bottom: 40px;
        padding: 30px;
        background: linear-gradient(135deg, #002748 0%, #004080 100%);
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        color: white;
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
        gap: 25px;
    }

    .quote-header-logo {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quote-header-logo img {
        width: 120px;
        height: auto;
        display: block;
    }

    .quote-header-company .company-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .quote-header-company .company-desc {
        font-size: 13px;
        opacity: 0.9;
        line-height: 1.6;
    }

    .quote-header-right {
        text-align: right;
    }

    .quote-header-right h2 {
        font-size: 42px;
        font-weight: 800;
        margin: 0 0 10px 0;
        letter-spacing: 3px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        color: white;
    }

    .quote-header-right .quote-number {
        font-size: 16px;
        font-weight: 600;
        background: rgba(255,255,255,0.15);
        padding: 8px 16px;
        border-radius: 6px;
        display: inline-block;
        backdrop-filter: blur(5px);
    }

    .quote-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin: 30px 0;
    }

    .info-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        border-left: 5px solid #002748;
    }

    .info-section h4 {
        color: #002748;
        margin-bottom: 20px;
        font-size: 14px;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 1px;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 10px;
    }

    .info-section p {
        margin: 10px 0;
        color: #555;
        font-size: 14px;
        line-height: 1.6;
        display: flex;
    }

    .info-section p strong {
        color: #333;
        font-weight: 600;
        min-width: 120px;
        display: inline-block;
    }

    .items-section {
        margin-top: 40px;
    }

    .items-section h4 {
        color: #002748;
        margin-bottom: 20px;
        font-size: 18px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .items-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 20px 0;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }

    .items-table th {
        background: #f1f3f5;
        color: #333;
        font-weight: 700;
        padding: 15px;
        text-align: left;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #dee2e6;
    }

    .items-table td {
        padding: 15px;
        border-bottom: 1px solid #e9ecef;
        background: white;
        color: #555;
    }

    .items-table tbody tr:last-child td {
        border-bottom: none;
    }

    .text-right {
        text-align: right;
    }

    .totals {
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .total-row {
        display: flex;
        justify-content: flex-end;
        gap: 40px;
        padding: 12px 20px;
        min-width: 300px;
    }

    .total-label {
        font-weight: 600;
        color: #666;
    }

    .total-value {
        text-align: right;
        font-weight: 600;
        color: #333;
    }

    .grand-total {
        background: #002748;
        color: white;
        font-size: 18px;
        font-weight: 700;
        border-radius: 8px;
        padding: 20px 30px;
        margin-top: 15px;
        box-shadow: 0 4px 10px rgba(0,39,72,0.2);
    }

    .grand-total .total-label,
    .grand-total .total-value {
        color: white;
    }

    .terms-section {
        margin-top: 40px;
        padding: 30px;
        background: #fff8f0;
        border-radius: 10px;
        border-left: 5px solid #FF6B00;
    }

    .terms-section h4 {
        color: #d35400;
        margin-bottom: 20px;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .terms-section p {
        margin: 12px 0;
        color: #555;
        font-size: 14px;
        line-height: 1.7;
    }

    .terms-section p strong {
        color: #333;
        font-weight: 700;
        margin-right: 5px;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: space-between;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    #pdfPreview {
        width: 100%;
        height: 800px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin: 20px 0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.quotes') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Quotes
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        $data = $quoteRequest->quote_data;
        $isKorean = $quoteRequest->quote_template == 'ko';
        $currencySymbol = $isKorean ? '₩' : '$';
        $decimals = $isKorean ? 0 : 2;

        $subtotal = 0;
        foreach ($data['items'] as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }

        $vat = 0;
        $grandTotal = $subtotal;
        if ($isKorean) {
            $vat = $subtotal * 0.10;
            $grandTotal = $subtotal + $vat;
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
                <h4><i class="fas fa-file-invoice"></i> Quote Information</h4>
                <p><strong>Quote Number:</strong> {{ $data['quote_number'] }}</p>
                <p><strong>Date:</strong> {{ date('F d, Y', strtotime($data['quote_date'])) }}</p>
                <p><strong>Valid Until:</strong> {{ date('F d, Y', strtotime($data['valid_until'])) }}</p>
                <p><strong>Currency:</strong> {{ $quoteRequest->quote_template == 'en' ? 'USD' : 'KRW' }}</p>
            </div>

            <div class="info-section">
                <h4><i class="fas fa-user"></i> Customer Information</h4>
                <p><strong>Company:</strong> {{ $quoteRequest->company_name }}</p>
                <p><strong>Contact:</strong> {{ $quoteRequest->contact_name }}</p>
                <p><strong>Email:</strong> {{ $quoteRequest->company_email }}</p>
                <p><strong>Phone:</strong> {{ $quoteRequest->phone }}</p>
            </div>
        </div>

        <div class="items-section">
            <h4><i class="fas fa-list-alt"></i> Line Items</h4>
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
                    <td class="text-right">{{ $currencySymbol }}{{ number_format($item['unit_price'], $decimals) }}</td>
                    <td class="text-right">{{ $currencySymbol }}{{ number_format($item['quantity'] * $item['unit_price'], $decimals) }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>

            <div class="totals">
                <div class="total-row">
                    <span class="total-label">Subtotal:</span>
                    <span class="total-value">{{ $currencySymbol }}{{ number_format($subtotal, $decimals) }}</span>
                </div>
                @if($isKorean)
                <div class="total-row">
                    <span class="total-label">VAT (10%):</span>
                    <span class="total-value">{{ $currencySymbol }}{{ number_format($vat, $decimals) }}</span>
                </div>
                @endif
                <div class="total-row grand-total">
                    <span class="total-label">Total Amount:</span>
                    <span class="total-value">{{ $currencySymbol }}{{ number_format($grandTotal, $decimals) }}</span>
                </div>
            </div>
        </div>

        @if($data['payment_terms'] || $data['delivery_terms'] || $data['notes'])
        <div class="terms-section">
            <h4><i class="fas fa-gavel"></i> Terms & Conditions</h4>
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
        <h3 style="margin-bottom: 15px; color: var(--primary-color);"><i class="fas fa-file-pdf"></i> PDF Preview</h3>
        <iframe id="pdfPreview" src="{{ asset('storage/' . $quoteRequest->quote_pdf) }}"></iframe>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="action-buttons">
        <div>
            <a href="{{ route('admin.quote.builder', $quoteRequest->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Quote
            </a>
        </div>
        <div style="display: flex; gap: 15px;">
            <button type="button" class="btn btn-primary" onclick="generatePDF()">
                <i class="fas fa-file-pdf"></i> {{ $quoteRequest->quote_pdf ? 'Regenerate PDF' : 'Generate PDF' }}
            </button>
            @if($quoteRequest->quote_pdf)
            <form action="{{ route('admin.quote.send', $quoteRequest->id) }}" method="POST" style="display: inline;"
                  onsubmit="return confirm('Send quote to {{ $quoteRequest->company_email }}?')">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-paper-plane"></i> Send Quote via Email
                </button>
            </form>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
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
@endsection
