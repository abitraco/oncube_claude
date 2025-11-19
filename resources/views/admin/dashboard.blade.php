@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('styles')
<style>
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-info h3 {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
    }

    .stat-info p {
        color: #666;
        font-size: 14px;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
    }

    .action-card {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        text-align: center;
        transition: transform 0.3s;
        text-decoration: none;
        color: inherit;
        display: block;
        border: 1px solid transparent;
    }

    .action-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary-color);
    }

    .action-icon {
        font-size: 48px;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .action-card h2 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #333;
    }

    .action-card p {
        color: #666;
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #e3f2fd; color: #0d47a1;">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-info">
                <h3>{{ \App\QuoteRequest::count() }}</h3>
                <p>Total Quotes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #fff3e0; color: #e65100;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ \App\QuoteRequest::where('status', 'pending')->count() }}</h3>
                <p>Pending Quotes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #e8f5e9; color: #1b5e20;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ \App\QuoteRequest::where('status', 'quote_sent')->count() }}</h3>
                <p>Sent Quotes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #f3e5f5; color: #4a148c;">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <h3>{{ \App\FeaturedProduct::count() }}</h3>
                <p>Featured Products</p>
            </div>
        </div>
    </div>

    <h2 style="margin-bottom: 20px; font-size: 18px; color: #555;">Quick Actions</h2>

    <div class="quick-actions">
        <a href="{{ route('admin.quotes') }}" class="action-card">
            <div class="action-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <h2>Manage Quote Requests</h2>
            <p>View and manage customer quote requests. Track inquiries and respond to potential clients.</p>
            <span class="btn btn-primary">Go to Quotes</span>
        </a>

        <a href="{{ route('admin.featured-products') }}" class="action-card">
            <div class="action-icon"><i class="fas fa-box-open"></i></div>
            <h2>Manage Featured Products</h2>
            <p>Add, edit, and organize featured products displayed on your homepage.</p>
            <span class="btn btn-primary">Go to Products</span>
        </a>
    </div>
@endsection
