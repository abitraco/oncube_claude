@extends('layouts.admin')

@section('title', 'Quote Builder')
@section('header_title', 'Quote Builder')

@section('styles')
<style>
    .customer-info {
        background: white;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .customer-info h3 {
        margin-bottom: 20px;
        color: var(--primary-color);
        font-size: 18px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-weight: 600;
        color: #666;
        font-size: 12px;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .info-value {
        color: #333;
        font-size: 15px;
    }

    .form-section {
        background: white;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .form-section h3 {
        margin-bottom: 20px;
        color: var(--primary-color);
        font-size: 18px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
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
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    input:focus, textarea:focus, select:focus {
        border-color: var(--primary-color);
        outline: none;
    }

    textarea {
        min-height: 100px;
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
        border: 2px solid #eee;
        border-radius: 10px;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s;
        background: #f8f9fa;
    }

    .template-option:hover {
        border-color: var(--primary-color);
        background: white;
    }

    .template-option.selected {
        border-color: var(--primary-color);
        background: #e3f2fd;
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
        padding: 12px;
        text-align: left;
        border: 1px solid #eee;
    }

    .items-table th {
        background: #f8f9fa;
        color: #333;
        font-weight: 600;
    }

    .items-table input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .btn-add-item {
        background: #28a745;
        color: white;
        padding: 8px 16px;
        margin-bottom: 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s;
    }

    .btn-add-item:hover {
        background: #218838;
    }

    .btn-remove {
        background: #dc3545;
        color: white;
        padding: 6px 12px;
        font-size: 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-remove:hover {
        background: #c82333;
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
        color: #666;
    }

    .total-value {
        min-width: 120px;
        text-align: right;
        font-weight: 600;
    }

    .grand-total {
        font-size: 20px;
        color: var(--primary-color);
        font-weight: bold;
        border-top: 2px solid #ddd;
        padding-top: 15px;
        margin-top: 15px;
    }

    .grand-total .total-value {
        color: var(--primary-color);
    }
</style>
@endsection

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.quotes') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Quotes
        </a>
    </div>

    <!-- Customer Information -->
    <div class="customer-info">
        <h3><i class="fas fa-user-circle"></i> Customer Information</h3>
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
        <div class="info-item" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
            <span class="info-label">Customer Message</span>
            <span class="info-value" style="white-space: pre-wrap;">{{ $quoteRequest->message }}</span>
        </div>
        @endif
    </div>

    <!-- Quote Form -->
    <form action="{{ route('admin.quote.save', $quoteRequest->id) }}" method="POST" id="quoteForm">
        @csrf

        <!-- Template Selection -->
        <div class="form-section">
            <h3><i class="fas fa-file-alt"></i> Select Quote Template</h3>
            <div class="template-selector">
                <div class="template-option" onclick="selectTemplate('en')">
                    <input type="radio" name="quote_template" value="en" id="template_en" required>
                    <label for="template_en" style="cursor: pointer;">
                        <strong>English Template</strong><br>
                        <small style="color: #666;">International Standard (USD)</small>
                    </label>
                </div>
                <div class="template-option" onclick="selectTemplate('ko')">
                    <input type="radio" name="quote_template" value="ko" id="template_ko" required>
                    <label for="template_ko" style="cursor: pointer;">
                        <strong>Korean Template</strong><br>
                        <small style="color: #666;">Domestic Standard (KRW)</small>
                    </label>
                </div>
            </div>
        </div>

        <!-- Quote Details -->
        <div class="form-section">
            <h3><i class="fas fa-info-circle"></i> Quote Details</h3>
            @php
                $quoteData = $quoteRequest->quote_data;
                $defaultQuoteNumber = 'Q-' . date('Ymd') . '-' . str_pad($quoteRequest->id, 4, '0', STR_PAD_LEFT);
            @endphp
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div class="form-group">
                    <label for="quote_number">Quote Number <span style="color: red">*</span></label>
                    <input type="text" name="quote_number" id="quote_number"
                           value="{{ $quoteData['quote_number'] ?? $defaultQuoteNumber }}" required>
                </div>
                <div class="form-group">
                    <label for="quote_date">Quote Date <span style="color: red">*</span></label>
                    <input type="date" name="quote_date" id="quote_date"
                           value="{{ $quoteData['quote_date'] ?? date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="valid_until">Valid Until <span style="color: red">*</span></label>
                    <input type="date" name="valid_until" id="valid_until"
                           value="{{ $quoteData['valid_until'] ?? date('Y-m-d', strtotime('+10 days')) }}" required>
                </div>
            </div>
        </div>

        <!-- Line Items -->
        <div class="form-section">
            <h3><i class="fas fa-list"></i> Line Items</h3>
            <button type="button" class="btn btn-add-item" onclick="addItem()">
                <i class="fas fa-plus"></i> Add Item
            </button>

            <div style="overflow-x: auto;">
                <table class="items-table" id="itemsTable">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">#</th>
                            <th style="min-width: 300px;">Description <span style="color: red">*</span></th>
                            <th style="width: 100px;">Qty <span style="color: red">*</span></th>
                            <th style="width: 150px;">Unit Price <span style="color: red">*</span></th>
                            <th style="width: 150px;">Amount</th>
                            <th style="width: 80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        @if($quoteData && isset($quoteData['items']) && count($quoteData['items']) > 0)
                            @foreach($quoteData['items'] as $index => $item)
                                @php
                                    $amount = $item['quantity'] * $item['unit_price'];
                                    $isKorean = isset($quoteData['quote_template']) && $quoteData['quote_template'] == 'ko';
                                    $amountDisplay = $isKorean ? '₩' . number_format($amount, 0) : '$' . number_format($amount, 2);
                                @endphp
                                <tr data-row="{{ $index }}">
                                    <td style="text-align: center;">{{ $index + 1 }}</td>
                                    <td><input type="text" name="items[{{ $index }}][description]" value="{{ $item['description'] }}" required placeholder="Item description"></td>
                                    <td><input type="number" name="items[{{ $index }}][quantity]" step="1" min="1" value="{{ $item['quantity'] }}" onchange="calculateRow({{ $index }})" required></td>
                                    <td><input type="number" name="items[{{ $index }}][unit_price]" step="0.01" min="0" value="{{ $item['unit_price'] }}" onchange="calculateRow({{ $index }})" required></td>
                                    <td><span class="item-amount">{{ $amountDisplay }}</span></td>
                                    <td style="text-align: center;"><button type="button" class="btn btn-remove" onclick="removeItem({{ $index }})"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            @endforeach
                        @else
                            <tr data-row="0">
                                <td style="text-align: center;">1</td>
                                <td><input type="text" name="items[0][description]" required placeholder="Item description"></td>
                                <td><input type="number" name="items[0][quantity]" step="1" min="1" value="1" onchange="calculateRow(0)" required></td>
                                <td><input type="number" name="items[0][unit_price]" step="0.01" min="0" onchange="calculateRow(0)" required></td>
                                <td><span class="item-amount">$0.00</span></td>
                                <td style="text-align: center;"><button type="button" class="btn btn-remove" onclick="removeItem(0)"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="totals">
                <div class="total-row">
                    <span class="total-label">Subtotal:</span>
                    <span class="total-value" id="subtotal">$0.00</span>
                </div>
                <div class="total-row" id="vat-row" style="display: none;">
                    <span class="total-label">VAT (10%):</span>
                    <span class="total-value" id="vat">$0.00</span>
                </div>
                <div class="total-row grand-total">
                    <span class="total-label">Total Amount:</span>
                    <span class="total-value" id="total">$0.00</span>
                </div>
            </div>
        </div>

        <!-- Terms & Conditions -->
        <div class="form-section">
            <h3><i class="fas fa-gavel"></i> Terms & Conditions</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div class="form-group">
                    <label for="payment_terms">Payment Terms</label>
                    <input type="text" name="payment_terms" id="payment_terms"
                           value="{{ $quoteData['payment_terms'] ?? '' }}"
                           placeholder="e.g., 50% deposit, 50% before shipment">
                </div>
                <div class="form-group">
                    <label for="delivery_terms">Delivery Terms</label>
                    <input type="text" name="delivery_terms" id="delivery_terms"
                           value="{{ $quoteData['delivery_terms'] ?? '' }}"
                           placeholder="e.g., FOB, CIF, EXW">
                </div>
            </div>
            <div class="form-group">
                <label for="notes">Additional Notes</label>
                <textarea name="notes" id="notes" placeholder="Add any special terms or notes...">{{ $quoteData['notes'] ?? '' }}</textarea>
            </div>
        </div>

        <div style="display: flex; gap: 15px; justify-content: flex-end; margin-bottom: 50px;">
            <a href="{{ route('admin.quotes') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save & Review Quote
            </button>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        // Default terms & conditions by template
        const defaultTerms = {
            en: {
                payment_terms: '100% Payment upon PO via wire (Bank fee is buyer\'s responsibility)',
                delivery_terms: '',
                notes: '- Lead time: 2~3 weeks\n- Shipping cost is included and mailed by FedEx\n- Customs clearance and taxes incurred in the UK are not our responsibility and it\'s not avialable to charge back with the reason caused by the customs problem.'
            },
            ko: {
                payment_terms: '발주시 100% 결제',
                delivery_terms: '',
                notes: '- Lead time: 발주 후 7~10일\n- Condition: New\n- 견적금액은 상품금액, 현지화물 및 핸들링비용, 국제운송료, 수입세금, 국내화물비용, 통관수수료 등 모든 비용이 포함된 금액입니다.\n- 상품금액이 공급업체로 결제된 이후에는 주문취소가 불가합니다.\n- 정보확인 미흡으로 발생되는 문제는 폐사에서 책임질 수 없습니다.(부품유무, 모양, 작동조건, 작동상태 등)'
            }
        };

        function selectTemplate(template) {
            document.getElementById('template_' + template).checked = true;
            document.querySelectorAll('.template-option').forEach(el => el.classList.remove('selected'));
            event.currentTarget.classList.add('selected');

            // Show/hide VAT based on template
            const vatRow = document.getElementById('vat-row');
            if (template === 'ko') {
                vatRow.style.display = '';
            } else {
                vatRow.style.display = 'none';
            }

            // Update terms & conditions if fields are empty or have old default values
            const paymentTermsField = document.getElementById('payment_terms');
            const deliveryTermsField = document.getElementById('delivery_terms');
            const notesField = document.getElementById('notes');

            // Only update if fields are empty (new quote)
            if (!paymentTermsField.value || paymentTermsField.value === defaultTerms.en.payment_terms || paymentTermsField.value === defaultTerms.ko.payment_terms) {
                paymentTermsField.value = defaultTerms[template].payment_terms;
            }
            if (!deliveryTermsField.value || deliveryTermsField.value === defaultTerms.en.delivery_terms || deliveryTermsField.value === defaultTerms.ko.delivery_terms) {
                deliveryTermsField.value = defaultTerms[template].delivery_terms;
            }
            if (!notesField.value || notesField.value === defaultTerms.en.notes || notesField.value === defaultTerms.ko.notes) {
                notesField.value = defaultTerms[template].notes;
            }

            // Update all row amounts with correct currency
            document.querySelectorAll('#itemsBody tr').forEach((row, index) => {
                const quantity = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
                const unitPrice = parseFloat(row.querySelector('input[name*="[unit_price]"]').value) || 0;
                const amount = quantity * unitPrice;

                if (template === 'ko') {
                    row.querySelector('.item-amount').textContent = '₩' + Math.round(amount).toLocaleString('en-US');
                } else {
                    row.querySelector('.item-amount').textContent = '$' + amount.toFixed(2);
                }
            });

            // Recalculate totals
            calculateTotal();
        }

        function addItem() {
            const tbody = document.getElementById('itemsBody');
            const currentRowCount = tbody.querySelectorAll('tr').length;
            const row = document.createElement('tr');
            row.setAttribute('data-row', currentRowCount);

            // Check if Korean template is selected
            const koTemplate = document.getElementById('template_ko');
            const isKorean = koTemplate && koTemplate.checked;
            const amountDisplay = isKorean ? '₩0' : '$0.00';

            row.innerHTML = `
                <td style="text-align: center;">${currentRowCount + 1}</td>
                <td><input type="text" name="items[${currentRowCount}][description]" required placeholder="Item description"></td>
                <td><input type="number" name="items[${currentRowCount}][quantity]" step="1" min="1" value="1" onchange="calculateRow(${currentRowCount})" required></td>
                <td><input type="number" name="items[${currentRowCount}][unit_price]" step="0.01" min="0" onchange="calculateRow(${currentRowCount})" required></td>
                <td><span class="item-amount">${amountDisplay}</span></td>
                <td style="text-align: center;"><button type="button" class="btn btn-remove" onclick="removeItem(${currentRowCount})"><i class="fas fa-trash"></i></button></td>
            `;
            tbody.appendChild(row);
            updateRowNumbers();
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

            // Check if Korean template is selected
            const koTemplate = document.getElementById('template_ko');
            const isKorean = koTemplate && koTemplate.checked;

            if (isKorean) {
                row.querySelector('.item-amount').textContent = '₩' + Math.round(amount).toLocaleString('en-US');
            } else {
                row.querySelector('.item-amount').textContent = '$' + amount.toFixed(2);
            }
            calculateTotal();
        }

        function calculateTotal() {
            let subtotal = 0;
            document.querySelectorAll('#itemsBody tr').forEach(row => {
                const quantity = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
                const unitPrice = parseFloat(row.querySelector('input[name*="[unit_price]"]').value) || 0;
                subtotal += quantity * unitPrice;
            });

            // Check if Korean template is selected
            const koTemplate = document.getElementById('template_ko');
            const isKorean = koTemplate && koTemplate.checked;

            if (isKorean) {
                const vat = subtotal * 0.10;
                const total = subtotal + vat;
                document.getElementById('subtotal').textContent = '₩' + Math.round(subtotal).toLocaleString('en-US');
                document.getElementById('vat').textContent = '₩' + Math.round(vat).toLocaleString('en-US');
                document.getElementById('total').textContent = '₩' + Math.round(total).toLocaleString('en-US');
            } else {
                document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
                document.getElementById('total').textContent = '$' + subtotal.toFixed(2);
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            @if($quoteRequest->quote_template)
                // Existing quote - select saved template
                selectTemplate('{{ $quoteRequest->quote_template }}');
            @else
                // New quote - set default terms for English template
                const paymentTermsField = document.getElementById('payment_terms');
                const deliveryTermsField = document.getElementById('delivery_terms');
                const notesField = document.getElementById('notes');

                if (!paymentTermsField.value) {
                    paymentTermsField.value = defaultTerms.en.payment_terms;
                }
                if (!deliveryTermsField.value) {
                    deliveryTermsField.value = defaultTerms.en.delivery_terms;
                }
                if (!notesField.value) {
                    notesField.value = defaultTerms.en.notes;
                }

                // Default: hide VAT for English template if none selected
                const vatRow = document.getElementById('vat-row');
                vatRow.style.display = 'none';
            @endif

            // Calculate totals if there are saved items
            @if($quoteData && isset($quoteData['items']) && count($quoteData['items']) > 0)
                calculateTotal();
            @endif
        });
    </script>
@endsection
