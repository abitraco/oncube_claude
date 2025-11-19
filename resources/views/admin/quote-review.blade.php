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
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #002748;
        }

        .quote-header h2 {
            color: #002748;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .quote-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .info-section h4 {
            color: #002748;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
        }

        .info-section p {
            margin: 5px 0;
            color: #333;
            font-size: 14px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .items-table th {
            background: #002748;
            color: white;
            font-weight: 600;
        }

        .items-table tr:hover {
            background: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .total-row {
            display: flex;
            justify-content: flex-end;
            gap: 30px;
            margin-bottom: 10px;
        }

        .total-label {
            font-weight: 600;
            min-width: 150px;
        }

        .total-value {
            min-width: 120px;
            text-align: right;
        }

        .grand-total {
            font-size: 20px;
            color: #002748;
            font-weight: bold;
            border-top: 2px solid #002748;
            padding-top: 15px;
            margin-top: 10px;
        }

        .terms-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .terms-section h4 {
            color: #002748;
            margin-bottom: 10px;
        }

        .terms-section p {
            margin: 5px 0;
            color: #555;
            font-size: 14px;
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
                <h2>QUOTATION</h2>
                <p style="color: #666;">ONCUBE GLOBAL</p>
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

            <h4 style="margin: 20px 0 10px 0; color: #002748;">Line Items</h4>
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
                @if(!$quoteRequest->quote_pdf)
                <button type="button" class="btn btn-primary" onclick="generatePDF()">
                    Generate PDF
                </button>
                @endif
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
