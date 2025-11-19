<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quote Builder - Admin Panel</title>
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
            max-width: 1200px;
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

        .btn-primary:hover {
            background: #003B5C;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .customer-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .customer-info h3 {
            margin-bottom: 15px;
            color: #002748;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .info-value {
            color: #333;
            font-size: 14px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h3 {
            margin-bottom: 15px;
            color: #002748;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        .template-selector {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .template-option {
            flex: 1;
            padding: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
        }

        .template-option:hover {
            border-color: #002748;
        }

        .template-option.selected {
            border-color: #002748;
            background: #EDF3F6;
        }

        .template-option input[type="radio"] {
            margin-right: 10px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th,
        .items-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .items-table th {
            background: #002748;
            color: white;
        }

        .items-table input {
            width: 100%;
            padding: 5px;
        }

        .btn-add-item {
            background: #19BD0A;
            color: white;
            padding: 8px 16px;
            margin-bottom: 20px;
        }

        .btn-remove {
            background: #dc3545;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
        }

        .totals {
            text-align: right;
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .total-row {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
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
            font-size: 18px;
            color: #002748;
            font-weight: bold;
            border-top: 2px solid #002748;
            padding-top: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Quote Builder</h1>
            <a href="{{ route('admin.quotes') }}" class="btn btn-secondary">Back to Quotes</a>
        </div>

        <!-- Customer Information -->
        <div class="customer-info">
            <h3>Customer Information</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Company Name</span>
                    <span class="info-value">{{ $quoteRequest->company_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Contact Name</span>
                    <span class="info-value">{{ $quoteRequest->contact_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $quoteRequest->company_email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone</span>
                    <span class="info-value">{{ $quoteRequest->phone }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Inquiry Type</span>
                    <span class="info-value">{{ $quoteRequest->inquiry_type }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Quantity</span>
                    <span class="info-value">{{ $quoteRequest->quantity ?? 'N/A' }}</span>
                </div>
            </div>
            @if($quoteRequest->message)
            <div class="info-item" style="margin-top: 15px;">
                <span class="info-label">Customer Message</span>
                <span class="info-value">{{ $quoteRequest->message }}</span>
            </div>
            @endif
        </div>

        <!-- Quote Form -->
        <form action="{{ route('admin.quote.save', $quoteRequest->id) }}" method="POST" id="quoteForm">
            @csrf

            <!-- Template Selection -->
            <div class="form-section">
                <h3>Select Quote Template</h3>
                <div class="template-selector">
                    <div class="template-option" onclick="selectTemplate('en')">
                        <input type="radio" name="quote_template" value="en" id="template_en" required>
                        <label for="template_en" style="cursor: pointer;">
                            <strong>English Template</strong><br>
                            <small>견적서_US.xlsx</small>
                        </label>
                    </div>
                    <div class="template-option" onclick="selectTemplate('ko')">
                        <input type="radio" name="quote_template" value="ko" id="template_ko" required>
                        <label for="template_ko" style="cursor: pointer;">
                            <strong>Korean Template</strong><br>
                            <small>견적서양식_KO.xlsx</small>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Quote Details -->
            <div class="form-section">
                <h3>Quote Details</h3>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    <div class="form-group">
                        <label for="quote_number">Quote Number *</label>
                        <input type="text" name="quote_number" id="quote_number"
                               value="Q-{{ date('Ymd') }}-{{ str_pad($quoteRequest->id, 4, '0', STR_PAD_LEFT) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="quote_date">Quote Date *</label>
                        <input type="date" name="quote_date" id="quote_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="valid_until">Valid Until *</label>
                        <input type="date" name="valid_until" id="valid_until" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                    </div>
                </div>
            </div>

            <!-- Line Items -->
            <div class="form-section">
                <h3>Line Items</h3>
                <button type="button" class="btn btn-add-item" onclick="addItem()">+ Add Item</button>

                <table class="items-table" id="itemsTable">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 40%">Description *</th>
                            <th style="width: 15%">Quantity *</th>
                            <th style="width: 15%">Unit Price (USD) *</th>
                            <th style="width: 15%">Amount</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        <tr data-row="0">
                            <td>1</td>
                            <td><input type="text" name="items[0][description]" required></td>
                            <td><input type="number" name="items[0][quantity]" step="1" min="1" value="1" onchange="calculateRow(0)" required></td>
                            <td><input type="number" name="items[0][unit_price]" step="0.01" min="0" onchange="calculateRow(0)" required></td>
                            <td><span class="item-amount">$0.00</span></td>
                            <td><button type="button" class="btn btn-remove" onclick="removeItem(0)">Remove</button></td>
                        </tr>
                    </tbody>
                </table>

                <div class="totals">
                    <div class="total-row">
                        <span class="total-label">Subtotal:</span>
                        <span class="total-value" id="subtotal">$0.00</span>
                    </div>
                    <div class="total-row grand-total">
                        <span class="total-label">Total Amount:</span>
                        <span class="total-value" id="total">$0.00</span>
                    </div>
                </div>
            </div>

            <!-- Terms & Conditions -->
            <div class="form-section">
                <h3>Terms & Conditions</h3>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div class="form-group">
                        <label for="payment_terms">Payment Terms</label>
                        <input type="text" name="payment_terms" id="payment_terms"
                               value="100% advance payment before shipment" placeholder="e.g., 50% deposit, 50% before shipment">
                    </div>
                    <div class="form-group">
                        <label for="delivery_terms">Delivery Terms</label>
                        <input type="text" name="delivery_terms" id="delivery_terms"
                               value="EXW (Ex Works) Korea" placeholder="e.g., FOB, CIF, EXW">
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes">Additional Notes</label>
                    <textarea name="notes" id="notes" placeholder="Add any special terms or notes...">Price is subject to change without notice.
Lead time: 2-4 weeks after order confirmation.
Warranty: 12 months from delivery date.</textarea>
                </div>
            </div>

            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <a href="{{ route('admin.quotes') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save & Review Quote</button>
            </div>
        </form>
    </div>

    <script>
        let itemCount = 1;

        function selectTemplate(template) {
            document.getElementById('template_' + template).checked = true;
            document.querySelectorAll('.template-option').forEach(el => el.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
        }

        function addItem() {
            const tbody = document.getElementById('itemsBody');
            const row = document.createElement('tr');
            row.setAttribute('data-row', itemCount);
            row.innerHTML = `
                <td>${itemCount + 1}</td>
                <td><input type="text" name="items[${itemCount}][description]" required></td>
                <td><input type="number" name="items[${itemCount}][quantity]" step="1" min="1" value="1" onchange="calculateRow(${itemCount})" required></td>
                <td><input type="number" name="items[${itemCount}][unit_price]" step="0.01" min="0" onchange="calculateRow(${itemCount})" required></td>
                <td><span class="item-amount">$0.00</span></td>
                <td><button type="button" class="btn btn-remove" onclick="removeItem(${itemCount})">Remove</button></td>
            `;
            tbody.appendChild(row);
            itemCount++;
        }

        function removeItem(rowIndex) {
            const row = document.querySelector(`tr[data-row="${rowIndex}"]`);
            if (row && document.querySelectorAll('#itemsBody tr').length > 1) {
                row.remove();
                updateRowNumbers();
                calculateTotal();
            }
        }

        function updateRowNumbers() {
            document.querySelectorAll('#itemsBody tr').forEach((row, index) => {
                row.querySelector('td:first-child').textContent = index + 1;
            });
        }

        function calculateRow(rowIndex) {
            const row = document.querySelector(`tr[data-row="${rowIndex}"]`);
            const quantity = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
            const unitPrice = parseFloat(row.querySelector('input[name*="[unit_price]"]').value) || 0;
            const amount = quantity * unitPrice;
            row.querySelector('.item-amount').textContent = '$' + amount.toFixed(2);
            calculateTotal();
        }

        function calculateTotal() {
            let subtotal = 0;
            document.querySelectorAll('#itemsBody tr').forEach(row => {
                const quantity = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
                const unitPrice = parseFloat(row.querySelector('input[name*="[unit_price]"]').value) || 0;
                subtotal += quantity * unitPrice;
            });

            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('total').textContent = '$' + subtotal.toFixed(2);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Set default template
            @if($quoteRequest->quote_template)
                selectTemplate('{{ $quoteRequest->quote_template }}');
            @endif
        });
    </script>
</body>
</html>
