@extends('layouts.admin')

@section('title', 'Featured Products')
@section('header_title', 'Featured Products Management')

@section('styles')
<style>
    .form-section {
        background: white;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .form-section h2 {
        margin-bottom: 20px;
        color: #333;
        font-size: 18px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
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

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        height: 100%;
        padding-top: 25px;
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #eee;
    }

    .no-image {
        width: 60px;
        height: 60px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        color: #adb5bd;
        font-size: 10px;
        border: 1px solid #eee;
    }

    .actions {
        display: flex;
        gap: 5px;
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
        backdrop-filter: blur(2px);
    }

    .modal-content {
        background: white;
        max-width: 700px;
        margin: 50px auto;
        padding: 30px;
        border-radius: 12px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    .modal-header h2 {
        font-size: 20px;
        color: var(--primary-color);
    }

    .close {
        font-size: 24px;
        cursor: pointer;
        color: #adb5bd;
        transition: color 0.2s;
    }

    .close:hover {
        color: #333;
    }
</style>
@endsection

@section('content')
    <div class="form-section">
        <h2><i class="fas fa-plus-circle"></i> Add New Product</h2>
        <form action="{{ route('admin.featured-products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Product Title <span style="color: red">*</span></label>
                    <input type="text" id="title" name="title" required placeholder="e.g. High Performance Motor">
                </div>
                <div class="form-group">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" id="subtitle" name="subtitle" placeholder="e.g. 5000W Industrial Grade">
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" placeholder="e.g. Parts & Components">
                </div>
                <div class="form-group">
                    <label for="price">Price (USD) <span style="color: red">*</span></label>
                    <input type="number" id="price" name="price" step="0.01" min="0" required placeholder="0.00">
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
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" checked style="width: 18px; height: 18px;">
                        <label for="is_active" style="margin: 0; cursor: pointer;">Active Status</label>
                    </div>
                </div>
            </div>
            <div style="margin-top: 25px; text-align: right;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Add Product
                </button>
            </div>
        </form>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 18px; color: #333;">Products List <span class="badge badge-secondary">{{ $products->count() }}</span></h2>
        </div>
        
        <div class="table-container">
            <table class="products-table">
                <thead>
                    <tr>
                        <th width="50">Order</th>
                        <th width="80">Image</th>
                        <th>Product Details</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Link</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td style="text-align: center; font-weight: bold; color: #666;">{{ $product->order }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                            @else
                                <div class="no-image"><i class="fas fa-image"></i></div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--primary-color);">{{ $product->title }}</div>
                            <div style="font-size: 12px; color: #666;">{{ $product->subtitle ?? '-' }}</div>
                        </td>
                        <td><span class="badge badge-secondary">{{ $product->category ?? 'Uncategorized' }}</span></td>
                        <td style="font-weight: 600;">${{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->product_url)
                                <a href="{{ $product->product_url }}" target="_blank" class="btn btn-secondary" style="padding: 4px 8px; font-size: 12px;">
                                    <i class="fas fa-link"></i> Link
                                </a>
                            @else
                                <span style="color: #ccc;">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <button onclick="editProduct({{ $product->id }}, '{{ addslashes($product->title) }}', '{{ addslashes($product->subtitle ?? '') }}', '{{ addslashes($product->category ?? '') }}', {{ $product->price }}, '{{ addslashes($product->product_url ?? '') }}', {{ $product->order }}, {{ $product->is_active ? 'true' : 'false' }})" class="btn btn-warning" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.featured-products.duplicate', $product->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-info" style="padding: 6px 10px; font-size: 12px;" title="Duplicate">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.featured-products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 12px;" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #999;">
                            <i class="fas fa-box-open" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                            <p>No products added yet. Use the form above to add your first product.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-edit"></i> Edit Product</h2>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="edit_title">Product Title <span style="color: red">*</span></label>
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
                        <label for="edit_price">Price (USD) <span style="color: red">*</span></label>
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
                        <small style="color: #666; margin-top: 5px;">Leave empty to keep current image</small>
                    </div>
                    <div class="form-group full-width">
                        <div class="checkbox-group">
                            <input type="checkbox" id="edit_is_active" name="is_active" style="width: 18px; height: 18px;">
                            <label for="edit_is_active" style="margin: 0; cursor: pointer;">Active Status</label>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 25px; display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-success">Update Product</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
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
@endsection
