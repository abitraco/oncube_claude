<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Products - Admin Panel</title>
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
            max-width: 1400px;
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

        .nav-links {
            display: flex;
            gap: 15px;
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

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-success {
            background: #19BD0A;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            font-size: 12px;
            padding: 6px 12px;
        }

        .btn-edit {
            background: #FF6B00;
            color: white;
            font-size: 12px;
            padding: 6px 12px;
        }

        .btn-duplicate {
            background: #17a2b8;
            color: white;
            font-size: 12px;
            padding: 6px 12px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .form-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .form-section h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .products-table th,
        .products-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .products-table th {
            background: #002748;
            color: white;
            font-weight: 600;
        }

        .products-table tr:hover {
            background: #f8f9fa;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        .no-image {
            width: 80px;
            height: 80px;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            color: #999;
            font-size: 12px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .modal-content {
            background: white;
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 8px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .close {
            font-size: 28px;
            cursor: pointer;
            color: #999;
        }

        .close:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Featured Products Management</h1>
            <div class="nav-links">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Dashboard</a>
                <a href="{{ route('admin.quotes') }}" class="btn btn-secondary">Quote Requests</a>
                <a href="{{ route('admin.logout') }}" class="btn btn-secondary">Logout</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-section">
            <h2>Add New Product</h2>
            <form action="{{ route('admin.featured-products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="title">Product Title *</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="subtitle">Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" id="category" name="category" placeholder="Parts & Components">
                    </div>
                    <div class="form-group">
                        <label for="price">Price (USD) *</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="product_url">Product URL</label>
                        <input type="url" id="product_url" name="product_url" placeholder="https://example.com/product">
                    </div>
                    <div class="form-group">
                        <label for="order">Display Order</label>
                        <input type="number" id="order" name="order" value="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="image">Product Image (Max 5MB)</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="is_active" name="is_active" checked>
                            <label for="is_active" style="margin: 0;">Active</label>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px;">
                    <button type="submit" class="btn btn-success">Add Product</button>
                </div>
            </form>
        </div>

        <h2 style="margin-bottom: 15px;">Products List ({{ $products->count() }})</h2>
        <table class="products-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Product URL</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->order }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                        @else
                            <div class="no-image">No Image</div>
                        @endif
                    </td>
                    <td><strong>{{ $product->title }}</strong></td>
                    <td>{{ $product->subtitle ?? '-' }}</td>
                    <td>{{ $product->category ?? '-' }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        @if($product->product_url)
                            <a href="{{ $product->product_url }}" target="_blank" style="color: #002748; text-decoration: none;">🔗 Link</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-inactive' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <button onclick="editProduct({{ $product->id }}, '{{ addslashes($product->title) }}', '{{ addslashes($product->subtitle ?? '') }}', '{{ addslashes($product->category ?? '') }}', {{ $product->price }}, '{{ addslashes($product->product_url ?? '') }}', {{ $product->order }}, {{ $product->is_active ? 'true' : 'false' }})" class="btn btn-edit">Edit</button>
                            <form action="{{ route('admin.featured-products.duplicate', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-duplicate">Duplicate</button>
                            </form>
                            <form action="{{ route('admin.featured-products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px; color: #999;">
                        No products added yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Product</h2>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="edit_title">Product Title *</label>
                        <input type="text" id="edit_title" name="title" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="edit_subtitle">Subtitle</label>
                        <input type="text" id="edit_subtitle" name="subtitle">
                    </div>
                    <div class="form-group">
                        <label for="edit_category">Category</label>
                        <input type="text" id="edit_category" name="category">
                    </div>
                    <div class="form-group">
                        <label for="edit_price">Price (USD) *</label>
                        <input type="number" id="edit_price" name="price" step="0.01" min="0" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="edit_product_url">Product URL</label>
                        <input type="url" id="edit_product_url" name="product_url" placeholder="https://example.com/product">
                    </div>
                    <div class="form-group">
                        <label for="edit_order">Display Order</label>
                        <input type="number" id="edit_order" name="order" min="0">
                    </div>
                    <div class="form-group">
                        <label for="edit_image">Product Image (Max 5MB)</label>
                        <input type="file" id="edit_image" name="image" accept="image/*">
                    </div>
                    <div class="form-group full-width">
                        <div class="checkbox-group">
                            <input type="checkbox" id="edit_is_active" name="is_active">
                            <label for="edit_is_active" style="margin: 0;">Active</label>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px; display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">Update Product</button>
                    <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editProduct(id, title, subtitle, category, price, productUrl, order, isActive) {
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_subtitle').value = subtitle;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_product_url').value = productUrl;
            document.getElementById('edit_order').value = order;
            document.getElementById('edit_is_active').checked = isActive;
            
            document.getElementById('editForm').action = `/admin/featured-products/${id}`;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>
