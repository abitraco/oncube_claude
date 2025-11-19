<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote History - ONCUBE Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #002748;
            font-size: 28px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-back {
            background: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.3s;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        .filters-card {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .filters-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 15px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #002748;
        }

        .btn-filter {
            background: #002748;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            height: 42px;
            transition: background 0.3s;
        }

        .btn-filter:hover {
            background: #003d6b;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-left: 4px solid;
        }

        .stat-card.total {
            border-left-color: #002748;
        }

        .stat-card.english {
            border-left-color: #0066cc;
        }

        .stat-card.korean {
            border-left-color: #FF6B00;
        }

        .stat-card.completed {
            border-left-color: #19BD0A;
        }

        .stat-label {
            font-size: 13px;
            color: #666;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #002748;
            margin-top: 8px;
        }

        .table-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #002748 0%, #004080 100%);
            color: white;
        }

        th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        tbody tr {
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .quote-number {
            font-weight: 700;
            color: #002748;
            font-size: 15px;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: inline-block;
        }

        .badge-en {
            background: #e3f2fd;
            color: #1565c0;
        }

        .badge-ko {
            background: #fff3e0;
            color: #e65100;
        }

        .badge-sent {
            background: #d4edda;
            color: #155724;
        }

        .badge-completed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-view {
            background: #002748;
            color: white;
        }

        .btn-view:hover {
            background: #003d6b;
        }

        .btn-download {
            background: #19BD0A;
            color: white;
        }

        .btn-download:hover {
            background: #15a008;
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #999;
            font-size: 16px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 20px;
            background: white;
            border-radius: 0 0 10px 10px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        @media (max-width: 768px) {
            .filters-form {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Quote History</h1>
            <div class="header-actions">
                <a href="{{ route('admin.quotes') }}" class="btn-back">← Back to Quote Requests</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-label">Total Quotes Sent</div>
                <div class="stat-value">{{ $quotes->total() }}</div>
            </div>
            <div class="stat-card english">
                <div class="stat-label">English Templates</div>
                <div class="stat-value">{{ App\QuoteRequest::whereNotNull('quote_pdf')->where('quote_template', 'en')->count() }}</div>
            </div>
            <div class="stat-card korean">
                <div class="stat-label">Korean Templates</div>
                <div class="stat-value">{{ App\QuoteRequest::whereNotNull('quote_pdf')->where('quote_template', 'ko')->count() }}</div>
            </div>
            <div class="stat-card completed">
                <div class="stat-label">Completed</div>
                <div class="stat-value">{{ App\QuoteRequest::where('status', 'completed')->count() }}</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-card">
            <form method="GET" action="{{ route('admin.quote-history') }}" class="filters-form">
                <div class="form-group">
                    <label>Search</label>
                    <input type="text" name="search" placeholder="Company name, contact, email..." value="{{ request('search') }}">
                </div>
                <div class="form-group">
                    <label>Template</label>
                    <select name="template">
                        <option value="">All Templates</option>
                        <option value="en" {{ request('template') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="ko" {{ request('template') == 'ko' ? 'selected' : '' }}>Korean</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="">All Status</option>
                        <option value="quote_sent" {{ request('status') == 'quote_sent' ? 'selected' : '' }}>Quote Sent</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">Apply Filters</button>
            </form>
        </div>

        <!-- Quote History Table -->
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%">Quote #</th>
                        <th style="width: 10%">Sent Date</th>
                        <th style="width: 18%">Company</th>
                        <th style="width: 15%">Contact</th>
                        <th style="width: 15%">Email</th>
                        <th style="width: 8%">Template</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 16%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotes as $quote)
                        @php
                            $data = $quote->quote_data;
                        @endphp
                        <tr>
                            <td>
                                <span class="quote-number">{{ $data['quote_number'] ?? '#' . $quote->id }}</span>
                            </td>
                            <td>{{ $quote->quote_sent_at ? \Carbon\Carbon::parse($quote->quote_sent_at)->format('Y-m-d H:i') : 'N/A' }}</td>
                            <td><strong>{{ $quote->company_name }}</strong></td>
                            <td>{{ $quote->contact_name }}</td>
                            <td>{{ $quote->company_email }}</td>
                            <td>
                                <span class="badge badge-{{ $quote->quote_template }}">
                                    {{ strtoupper($quote->quote_template ?? 'N/A') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $quote->status == 'completed' ? 'completed' : 'sent' }}">
                                    {{ $quote->status_label ?? ucfirst($quote->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.quote-history.view', $quote->id) }}" class="btn-action btn-view">View</a>
                                    <a href="{{ route('admin.quote-history.download', $quote->id) }}" class="btn-action btn-download">Download</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="no-data">
                                📭 No quote history found. Quotes will appear here after they are sent to customers.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($quotes->hasPages())
                <div class="pagination">
                    {{ $quotes->links('pagination::simple-default') }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
