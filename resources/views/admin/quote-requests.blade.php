<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quote Requests</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .admin-header {
            background: #002748;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .admin-header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .admin-nav {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .nav-link {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .nav-link.active {
            background: #FF6B00;
        }

        .admin-header .stats {
            display: flex;
            gap: 30px;
            margin-top: 15px;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 15px;
            border-radius: 5px;
        }

        .stat-item strong {
            font-size: 18px;
            display: block;
            color: #FFEC2D;
        }

        .filters {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-group label {
            font-size: 12px;
            color: #666;
            font-weight: 600;
        }

        .filter-group input,
        .filter-group select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #002748;
            color: white;
        }

        .btn-primary:hover {
            background: #003d6b;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .requests-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8f9fa;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e9ecef;
            font-size: 13px;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-quote {
            background: #e3f2fd;
            color: #1976d2;
        }

        .badge-bulk {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .badge-partnership {
            background: #e8f5e9;
            color: #388e3c;
        }

        .badge-other {
            background: #fff3e0;
            color: #f57c00;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-sent {
            background: #d4edda;
            color: #155724;
        }

        .badge-completed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .view-link {
            color: #002748;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }

        .view-link:hover {
            text-decoration: underline;
        }

        .btn-quote {
            background: #19BD0A;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-right: 5px;
        }

        .btn-quote:hover {
            background: #15a008;
        }

        .btn-view {
            background: #002748;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .btn-view:hover {
            background: #003d6b;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
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
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
            width: 90%;
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            font-size: 20px;
            color: #002748;
        }

        .close-btn {
            font-size: 28px;
            color: #999;
            cursor: pointer;
            border: none;
            background: none;
        }

        .close-btn:hover {
            color: #333;
        }

        .modal-body {
            padding: 20px;
        }

        .detail-row {
            margin-bottom: 20px;
        }

        .detail-label {
            font-weight: 600;
            color: #666;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #333;
            font-size: 14px;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }

        .pagination a:hover {
            background: #f8f9fa;
        }

        .pagination .active {
            background: #002748;
            color: white;
            border-color: #002748;
        }

        @media (max-width: 1200px) {
            table {
                font-size: 12px;
            }
            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>📋 Quote Requests Admin</h1>
                <p>Manage and review customer quote requests</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.dashboard') }}" style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 14px;">Dashboard</a>
                <a href="{{ route('admin.featured-products') }}" style="background: #FF6B00; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 14px;">Featured Products</a>
                <a href="{{ route('admin.logout') }}" style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 14px;">Logout</a>
            </div>
        </div>

        <div class="admin-nav">
            <a href="{{ route('admin.quotes') }}" class="nav-link active">Quote Requests</a>
            <a href="{{ route('admin.quote-history') }}" class="nav-link">Quote History</a>
        </div>

        <div class="stats">
            <div class="stat-item">
                <small>Total Requests</small>
                <strong>{{ $total }}</strong>
            </div>
            <div class="stat-item">
                <small>This Month</small>
                <strong>{{ $thisMonth }}</strong>
            </div>
            <div class="stat-item">
                <small>Today</small>
                <strong>{{ $today }}</strong>
            </div>
        </div>
    </div>

    <div class="filters">
        <div class="filter-group">
            <label>Search</label>
            <input type="text" id="searchInput" placeholder="Company, email, contact name...">
        </div>
        <div class="filter-group">
            <label>Inquiry Type</label>
            <select id="typeFilter">
                <option value="">All Types</option>
                <option value="견적문의">견적문의</option>
                <option value="대량구매">대량구매</option>
                <option value="사업제휴">사업제휴</option>
                <option value="기타">기타</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Date From</label>
            <input type="date" id="dateFrom">
        </div>
        <div class="filter-group">
            <label>Date To</label>
            <input type="date" id="dateTo">
        </div>
        <button class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
    </div>

    <div class="requests-table">
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
                                    <a href="{{ route('admin.quote.review', $request->id) }}" class="btn-view">View Quote</a>
                                @else
                                    <a href="{{ route('admin.quote.builder', $request->id) }}" class="btn-quote">Create Quote</a>
                                @endif
                                <a href="#" class="btn-view" onclick="viewDetails({{ $request->id }}); return false;">Details</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="no-data">No quote requests found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $requests->links('pagination::simple-default') }}
    </div>

    <!-- Modal -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Quote Request Details</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

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
                    <div class="detail-value"><a href="/storage/${request.attachment}" target="_blank">📎 Download Attachment</a></div>
                </div>
                ` : ''}
                <div class="detail-row">
                    <div class="detail-label">Locale</div>
                    <div class="detail-value">${request.locale}</div>
                </div>
            `;

            document.getElementById('detailModal').classList.add('active');
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
</body>
</html>
