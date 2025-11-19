@extends('layouts.admin')

@section('title', 'Quote Requests')
@section('header_title', 'Quote Requests Management')

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
    }

    .stat-card small {
        color: #666;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .stat-card strong {
        font-size: 24px;
        color: var(--primary-color);
    }

    .filters {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        align-items: flex-end;
        flex-wrap: wrap;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex: 1;
        min-width: 150px;
    }

    .filter-group label {
        font-size: 12px;
        color: #666;
        font-weight: 600;
    }

    .filter-group input,
    .filter-group select {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        width: 100%;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-quote { background: #e3f2fd; color: #1976d2; }
    .badge-bulk { background: #f3e5f5; color: #7b1fa2; }
    .badge-partnership { background: #e8f5e9; color: #388e3c; }
    .badge-other { background: #fff3e0; color: #f57c00; }
    
    .badge-pending { background: #fff3cd; color: #856404; }
    .badge-sent { background: #d4edda; color: #155724; }
    .badge-completed { background: #d1ecf1; color: #0c5460; }
    .badge-cancelled { background: #f8d7da; color: #721c24; }

    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        max-width: 700px;
        max-height: 90vh;
        overflow-y: auto;
        width: 90%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .modal-header {
        padding: 20px 25px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        font-size: 20px;
        color: var(--primary-color);
        margin: 0;
    }

    .close-btn {
        font-size: 24px;
        color: #adb5bd;
        cursor: pointer;
        border: none;
        background: none;
        transition: color 0.2s;
    }

    .close-btn:hover {
        color: #333;
    }

    .modal-body {
        padding: 25px;
    }

    .detail-row {
        margin-bottom: 20px;
        border-bottom: 1px solid #f8f9fa;
        padding-bottom: 15px;
    }

    .detail-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .detail-label {
        font-weight: 600;
        color: #666;
        font-size: 12px;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .detail-value {
        color: #333;
        font-size: 15px;
        line-height: 1.5;
    }

    .detail-value a {
        color: var(--accent-color);
        text-decoration: none;
    }

    .detail-value a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <small>Total Requests</small>
            <strong>{{ $total }}</strong>
        </div>
        <div class="stat-card">
            <small>This Month</small>
            <strong>{{ $thisMonth }}</strong>
        </div>
        <div class="stat-card">
            <small>Today</small>
            <strong>{{ $today }}</strong>
        </div>
    </div>

    <div class="filters">
        <div class="filter-group" style="flex: 2;">
            <label>Search</label>
            <input type="text" id="searchInput" placeholder="Company, email, contact name..." value="{{ request('search') }}">
        </div>
        <div class="filter-group">
            <label>Inquiry Type</label>
            <select id="typeFilter">
                <option value="">All Types</option>
                <option value="견적문의" {{ request('type') == '견적문의' ? 'selected' : '' }}>견적문의</option>
                <option value="대량구매" {{ request('type') == '대량구매' ? 'selected' : '' }}>대량구매</option>
                <option value="사업제휴" {{ request('type') == '사업제휴' ? 'selected' : '' }}>사업제휴</option>
                <option value="기타" {{ request('type') == '기타' ? 'selected' : '' }}>기타</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Date From</label>
            <input type="date" id="dateFrom" value="{{ request('from') }}">
        </div>
        <div class="filter-group">
            <label>Date To</label>
            <input type="date" id="dateTo" value="{{ request('to') }}">
        </div>
        <div class="filter-group" style="flex: 0; min-width: auto;">
            <label>&nbsp;</label>
            <button class="btn btn-primary" onclick="applyFilters()" style="height: 42px;">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>

    <div class="card">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr>
                            <td>#{{ $request->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($request->created_at)->format('Y-m-d H:i') }}</td>
                            <td><strong>{{ $request->company_name }}</strong></td>
                            <td>{{ $request->contact_name }}</td>
                            <td>{{ $request->company_email }}</td>
                            <td>{{ $request->phone }}</td>
                            <td>
                                <span class="badge badge-{{
                                    $request->inquiry_type == '견적문의' ? 'quote' :
                                    ($request->inquiry_type == '대량구매' ? 'bulk' :
                                    ($request->inquiry_type == '사업제휴' ? 'partnership' : 'other'))
                                }}">
                                    {{ $request->inquiry_type }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{
                                    $request->status == 'pending' ? 'pending' :
                                    ($request->status == 'quote_sent' ? 'sent' :
                                    ($request->status == 'completed' ? 'completed' : 'cancelled'))
                                }}">
                                    {{ $request->status_label ?? ucfirst($request->status ?? 'pending') }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if($request->status == 'quote_sent' && $request->quote_pdf)
                                        <a href="{{ route('admin.quote.review', $request->id) }}" class="btn btn-secondary" style="padding: 4px 8px; font-size: 11px;">
                                            <i class="fas fa-file-pdf"></i> View
                                        </a>
                                    @else
                                        <a href="{{ route('admin.quote.builder', $request->id) }}" class="btn btn-success" style="padding: 4px 8px; font-size: 11px;">
                                            <i class="fas fa-file-invoice-dollar"></i> Quote
                                        </a>
                                    @endif
                                    <button class="btn btn-info" onclick="viewDetails({{ $request->id }})" style="padding: 4px 8px; font-size: 11px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <form action="{{ route('admin.quotes.duplicate', $request->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Duplicate this quote request?')">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary" style="padding: 4px 8px; font-size: 11px; background-color: #6c757d; border-color: #6c757d; color: white;">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 40px; color: #999;">
                                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                                <p>No quote requests found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $requests->links('pagination::simple-default') }}
        </div>
    </div>

    <!-- Modal -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-info-circle"></i> Request Details</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const requestsData = @json($requests->items());

        function viewDetails(id) {
            const request = requestsData.find(r => r.id === id);
            if (!request) return;

            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                <div class="detail-row">
                    <div class="detail-label">Request ID</div>
                    <div class="detail-value">#${request.id}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Submitted Date</div>
                    <div class="detail-value">${new Date(request.created_at).toLocaleString()}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Company Name</div>
                    <div class="detail-value">${request.company_name}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Contact Name</div>
                    <div class="detail-value">${request.contact_name}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Company Email</div>
                    <div class="detail-value"><a href="mailto:${request.company_email}">${request.company_email}</a></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Phone</div>
                    <div class="detail-value"><a href="tel:${request.phone}">${request.phone}</a></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Inquiry Type</div>
                    <div class="detail-value">${request.inquiry_type}</div>
                </div>
                ${request.product_url ? `
                <div class="detail-row">
                    <div class="detail-label">Product URL</div>
                    <div class="detail-value"><a href="${request.product_url}" target="_blank">${request.product_url}</a></div>
                </div>
                ` : ''}
                ${request.quantity ? `
                <div class="detail-row">
                    <div class="detail-label">Quantity</div>
                    <div class="detail-value">${request.quantity}</div>
                </div>
                ` : ''}
                <div class="detail-row">
                    <div class="detail-label">Message</div>
                    <div class="detail-value" style="white-space: pre-wrap;">${request.message}</div>
                </div>
                ${request.attachment ? `
                <div class="detail-row">
                    <div class="detail-label">Attachment</div>
                    <div class="detail-value"><a href="/storage/${request.attachment}" target="_blank"><i class="fas fa-paperclip"></i> Download Attachment</a></div>
                </div>
                ` : ''}
                <div class="detail-row">
                    <div class="detail-label">Locale</div>
                    <div class="detail-value">${request.locale}</div>
                </div>
                
                <div style="margin-top: 20px; text-align: right; border-top: 1px solid #eee; padding-top: 20px;">
                    <button class="btn btn-warning" onclick="editDetails(${request.id})">
                        <i class="fas fa-edit"></i> Edit Details
                    </button>
                </div>
            `;

            document.getElementById('detailModal').classList.add('active');
        }

        function editDetails(id) {
            const request = requestsData.find(r => r.id === id);
            if (!request) return;

            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                <form action="/admin/quotes/${request.id}/update" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" name="company_name" value="${request.company_name}" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input type="text" name="contact_name" value="${request.contact_name}" required>
                    </div>
                    <div class="form-group">
                        <label>Company Email</label>
                        <input type="email" name="company_email" value="${request.company_email}" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="${request.phone}" required>
                    </div>
                    <div class="form-group">
                        <label>Inquiry Type</label>
                        <select name="inquiry_type">
                            <option value="견적문의" ${request.inquiry_type == '견적문의' ? 'selected' : ''}>견적문의</option>
                            <option value="대량구매" ${request.inquiry_type == '대량구매' ? 'selected' : ''}>대량구매</option>
                            <option value="사업제휴" ${request.inquiry_type == '사업제휴' ? 'selected' : ''}>사업제휴</option>
                            <option value="기타" ${request.inquiry_type == '기타' ? 'selected' : ''}>기타</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product URL</label>
                        <input type="text" name="product_url" value="${request.product_url || ''}">
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity" value="${request.quantity || ''}">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" rows="5" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">${request.message || ''}</textarea>
                    </div>
                    <div style="margin-top: 20px; display: flex; justify-content: space-between; border-top: 1px solid #eee; padding-top: 20px;">
                        <button type="button" class="btn btn-secondary" onclick="viewDetails(${request.id})">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            `;
        }

        function closeModal() {
            document.getElementById('detailModal').classList.remove('active');
        }

        function applyFilters() {
            const search = document.getElementById('searchInput').value;
            const type = document.getElementById('typeFilter').value;
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;

            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (type) params.append('type', type);
            if (dateFrom) params.append('from', dateFrom);
            if (dateTo) params.append('to', dateTo);

            window.location.href = '?' + params.toString();
        }

        // Close modal on outside click
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
@endsection
