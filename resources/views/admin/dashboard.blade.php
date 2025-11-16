<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ONCUBE GLOBAL</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #002748 0%, #004d7a 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .dashboard-header {
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }

        .dashboard-header h1 {
            font-size: 42px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .dashboard-header p {
            font-size: 18px;
            opacity: 0.9;
        }

        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .admin-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        }

        .admin-card-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .admin-card h2 {
            color: #002748;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .admin-card p {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .admin-card-button {
            display: inline-block;
            padding: 12px 30px;
            background: #002748;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .admin-card:hover .admin-card-button {
            background: #003d6b;
        }

        .logout-section {
            text-align: center;
            margin-top: 40px;
        }

        .logout-link {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 20px;
            border: 2px solid white;
            border-radius: 8px;
            display: inline-block;
            transition: background 0.2s, color 0.2s;
        }

        .logout-link:hover {
            background: white;
            color: #002748;
        }

        .home-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            margin-left: 15px;
        }

        .home-link:hover {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>🎛️ Admin Dashboard</h1>
            <p>Manage your business operations from one place</p>
        </div>

        <div class="admin-grid">
            <a href="{{ route('admin.quotes') }}" class="admin-card">
                <div class="admin-card-icon">📋</div>
                <h2>Quote Requests</h2>
                <p>View and manage customer quote requests. Track inquiries, respond to potential clients, and manage your sales pipeline.</p>
                <span class="admin-card-button">Manage Quotes</span>
            </a>

            <a href="{{ route('admin.featured-products') }}" class="admin-card">
                <div class="admin-card-icon">⭐</div>
                <h2>Featured Products</h2>
                <p>Add, edit, and organize featured products displayed on your homepage. Control what customers see first.</p>
                <span class="admin-card-button">Manage Products</span>
            </a>
        </div>

        <div class="logout-section">
            <a href="{{ route('admin.logout') }}" class="logout-link">🚪 Logout</a>
            <a href="{{ route('home', ['locale' => 'en']) }}" class="home-link">← Back to Home</a>
        </div>
    </div>
</body>
</html>
