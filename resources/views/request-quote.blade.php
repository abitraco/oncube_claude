@extends('layouts.app')

@section('title', 'Request a Quote - ONCUBE GLOBAL')
@section('meta_description', 'Request a quote for industrial and semiconductor equipment, parts, and services - Get competitive pricing and fast turnaround')

@section('content')
    <!-- Request Quote Hero -->
    <section class="contact-hero-section wave-background-top">
        <div class="container">
            <div class="contact-hero-content">
                <div class="contact-hero-text fade-in-up">
                    <h1 class="contact-hero-title" data-i18n="quote_page_title">Request a Quote</h1>
                    <p class="contact-hero-subtitle" data-i18n="quote_page_subtitle">
                        Get competitive pricing for industrial equipment and parts. Fill out the form and our team will respond within 24 hours.
                    </p>
                    <p class="contact-hero-intro" data-i18n="quote_page_intro">What you'll get:</p>
                    <ul class="contact-hero-list">
                        <li data-i18n="quote_benefit_1">Customized pricing for your business needs</li>
                        <li data-i18n="quote_benefit_2">Access to worldwide suppliers and inventory</li>
                        <li data-i18n="quote_benefit_3">Expert technical support and consultation</li>
                        <li data-i18n="quote_benefit_4">Fast turnaround time - 24 hour response</li>
                        <li data-i18n="quote_benefit_5">Volume discounts for bulk orders</li>
                        <li data-i18n="quote_benefit_6">International shipping quotes available</li>
                    </ul>

                    <div class="trusted-by-section">
                        <p class="trusted-by-title" data-i18n="quote_trusted_title">Trusted by businesses worldwide</p>
                        <div class="trusted-logos">
                            <div class="trusted-logo-item">
                                <svg width="80" height="30" viewBox="0 0 80 30" fill="none">
                                    <rect x="5" y="8" width="70" height="14" rx="2" fill="#002748"/>
                                    <text x="40" y="20" font-size="12" fill="#fff" text-anchor="middle" font-weight="bold">PARTNER 1</text>
                                </svg>
                            </div>
                            <div class="trusted-logo-item">
                                <svg width="80" height="30" viewBox="0 0 80 30" fill="none">
                                    <rect x="5" y="8" width="70" height="14" rx="2" fill="#002748"/>
                                    <text x="40" y="20" font-size="12" fill="#fff" text-anchor="middle" font-weight="bold">PARTNER 2</text>
                                </svg>
                            </div>
                            <div class="trusted-logo-item">
                                <svg width="80" height="30" viewBox="0 0 80 30" fill="none">
                                    <rect x="5" y="8" width="70" height="14" rx="2" fill="#002748"/>
                                    <text x="40" y="20" font-size="12" fill="#fff" text-anchor="middle" font-weight="bold">PARTNER 3</text>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-form-wrapper fade-in-up delay-1">
                    <!-- Internal Quote Form -->
                    <div class="quote-form-container">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-error">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('request-quote.store', ['locale' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" class="quote-form">
                            @csrf
                            
                            <div class="form-group">
                                <label for="company_email" class="form-label required" data-i18n="quote_email_label">Work Email Address</label>
                                <input type="email" id="company_email" name="company_email" class="form-input" value="{{ old('company_email') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="company_name" class="form-label required" data-i18n="quote_company_label">Company Name</label>
                                <input type="text" id="company_name" name="company_name" class="form-input" value="{{ old('company_name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label required" data-i18n="quote_phone_label">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone') }}" placeholder="+82-000-000-0000" required>
                            </div>

                            <div class="form-group">
                                <label for="contact_name" class="form-label required" data-i18n="quote_contact_label">Contact Name</label>
                                <input type="text" id="contact_name" name="contact_name" class="form-input" value="{{ old('contact_name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="product_url" class="form-label" data-i18n="quote_product_url_label">Product URL</label>
                                <input type="url" id="product_url" name="product_url" class="form-input" value="{{ request('product_url') ?? old('product_url') }}" placeholder="https://">
                            </div>

                            <div class="form-group">
                                <label for="inquiry_type" class="form-label required" data-i18n="quote_inquiry_type_label">Inquiry Type</label>
                                <select id="inquiry_type" name="inquiry_type" class="form-select" required>
                                    <option value="" data-i18n="quote_inquiry_select">Please Select</option>
                                    <option value="견적문의" {{ old('inquiry_type') == '견적문의' ? 'selected' : '' }} data-i18n="quote_inquiry_quote">Quote Inquiry</option>
                                    <option value="대량구매" {{ old('inquiry_type') == '대량구매' ? 'selected' : '' }} data-i18n="quote_inquiry_bulk">Bulk Purchase</option>
                                    <option value="사업제휴" {{ old('inquiry_type') == '사업제휴' ? 'selected' : '' }} data-i18n="quote_inquiry_partnership">Business Partnership</option>
                                    <option value="기타" {{ old('inquiry_type') == '기타' ? 'selected' : '' }} data-i18n="quote_inquiry_other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="quantity" class="form-label" data-i18n="quote_quantity_label">Quantity</label>
                                <input type="text" id="quantity" name="quantity" class="form-input" value="{{ old('quantity') }}" data-i18n-placeholder="quote_quantity_placeholder" placeholder="e.g., 10 units">
                            </div>

                            <div class="form-group">
                                <label for="message" class="form-label required" data-i18n="quote_message_label">Message</label>
                                <textarea id="message" name="message" class="form-textarea" rows="6" required>{{ old('message') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="attachment" class="form-label" data-i18n="quote_attachment_label">File Attachment</label>
                                <input type="file" id="attachment" name="attachment" class="form-file" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                                <small class="form-help" data-i18n="quote_attachment_help">Max 10MB, PDF, DOC, DOCX, XLS, XLSX, JPG, PNG formats</small>
                            </div>

                            <div class="form-group privacy-agreement">
                                <div class="privacy-content">
                                    <h4 data-i18n="quote_privacy_title">Privacy Policy Consent</h4>
                                    <div class="privacy-box">
                                        <p><strong>■</strong> <span data-i18n="quote_privacy_items">Collected Items: Company name, contact name, phone number, email</span></p>
                                        <p><strong>■</strong> <span data-i18n="quote_privacy_purpose">Collection Purpose: To respond to business purchase and quote inquiries and provide consultation</span></p>
                                        <p><strong>■</strong> <span data-i18n="quote_privacy_retention">Retention Period: 3 years from the date of inquiry (stored in accordance with relevant laws)</span></p>
                                        <p><strong>■</strong> <span data-i18n="quote_privacy_notice">Notice: You can refuse the collection and use of personal information, but refusal may limit inquiry reception and responses.</span></p>
                                    </div>
                                </div>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="privacy_agreed" value="1" {{ old('privacy_agreed') ? 'checked' : '' }} required>
                                    <span data-i18n="quote_privacy_agree">I agree to the collection and use of personal information (Required)</span>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-large" data-i18n="quote_submit_btn">
                                Submit Quote Request
                            </button>
                            
                            <!-- Hidden translation text for JS -->
                            <span style="display:none;" data-i18n="quote_privacy_alert">Please agree to the collection and use of personal information.</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>
@endsection

@push('styles')
    <style>
        .quote-form-container {
            background: white;
            padding: 2rem;
            border-radius: var(--radius-lg);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .quote-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--color-text-primary);
            font-size: 0.95rem;
        }

        .form-label.required::after {
            content: " *";
            color: #e53e3e;
        }

        .form-input,
        .form-select,
        .form-textarea {
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: var(--radius-md);
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.2s;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--color-primary);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-file {
            padding: 0.5rem;
            font-size: 0.95rem;
        }

        .form-help {
            color: #718096;
            font-size: 0.875rem;
        }

        .privacy-agreement {
            background: #f7fafc;
            padding: 1.5rem;
            border-radius: var(--radius-md);
            border: 1px solid #e2e8f0;
        }

        .privacy-content h4 {
            margin: 0 0 1rem 0;
            color: var(--color-text-primary);
            font-size: 1.1rem;
        }

        .privacy-box {
            background: white;
            padding: 1rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1rem;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .privacy-box p {
            margin: 0.5rem 0;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-weight: 500;
        }

        .checkbox-label input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            cursor: pointer;
        }

        .btn-large {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .quote-form-container {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Form validation and UX enhancements
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.quote-form');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    const privacyCheckbox = form.querySelector('input[name="privacy_agreed"]');
                    
                    if (!privacyCheckbox.checked) {
                        e.preventDefault();
                        const alertMsg = document.querySelector('[data-i18n="quote_privacy_alert"]');
                        const message = alertMsg ? alertMsg.textContent : 'Please agree to the collection and use of personal information.';
                        alert(message);
                        privacyCheckbox.focus();
                        return false;
                    }
                });
            }

            // Handle placeholder translation
            const placeholderElement = document.querySelector('[data-i18n-placeholder="quote_quantity_placeholder"]');
            if (placeholderElement && window.currentTranslations) {
                placeholderElement.placeholder = window.currentTranslations.quote_quantity_placeholder || placeholderElement.placeholder;
            }
        });
    </script>
@endpush
