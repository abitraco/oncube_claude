<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FeaturedProduct;
use Illuminate\Support\Facades\Storage;

class FeaturedProductController extends Controller
{
    public function index(Request $request)
    {
        // Check session authentication
        if ($request->session()->get('admin_authenticated') !== true) {
            if ($request->has('password')) {
                if ($request->input('password') === env('ADMIN_PASSWORD', 'oncube2024')) {
                    $request->session()->put('admin_authenticated', true);
                    return redirect()->route('admin.featured-products');
                } else {
                    return redirect()->route('admin.login', ['redirect' => 'featured-products'])
                        ->with('error', 'Invalid password');
                }
            } else {
                return redirect()->route('admin.login', ['redirect' => 'featured-products']);
            }
        }

        $products = FeaturedProduct::orderBy('order')->get();
        return view('admin.featured-products', compact('products'));
    }

    public function store(Request $request)
    {
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'featured-products']);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:5120',
            'order' => 'nullable|integer'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('featured-products', 'public');
        }

        FeaturedProduct::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'category' => $validated['category'] ?? null,
            'price' => $validated['price'],
            'image' => $imagePath,
            'product_url' => $validated['product_url'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.featured-products')->with('success', 'Product added successfully');
    }

    public function update(Request $request, $id)
    {
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'featured-products']);
        }

        $product = FeaturedProduct::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:5120',
            'product_url' => 'nullable|url|max:500',
            'order' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('featured-products', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $product->update($validated);

        return redirect()->route('admin.featured-products')->with('success', 'Product updated successfully');
    }

    public function duplicate(Request $request, $id)
    {
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'featured-products']);
        }

        $product = FeaturedProduct::findOrFail($id);
        
        // Get the highest order number and add 1
        $maxOrder = FeaturedProduct::max('order') ?? 0;
        
        // Create duplicate with copied image
        $imagePath = null;
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            $extension = pathinfo($product->image, PATHINFO_EXTENSION);
            $filename = 'featured-products/' . uniqid() . '.' . $extension;
            Storage::disk('public')->copy($product->image, $filename);
            $imagePath = $filename;
        }

        FeaturedProduct::create([
            'title' => $product->title . ' (Copy)',
            'subtitle' => $product->subtitle,
            'category' => $product->category,
            'price' => $product->price,
            'image' => $imagePath,
            'product_url' => $product->product_url,
            'order' => $maxOrder + 1,
            'is_active' => $product->is_active
        ]);

        return redirect()->route('admin.featured-products')->with('success', 'Product duplicated successfully');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login', ['redirect' => 'featured-products']);
        }

        $product = FeaturedProduct::findOrFail($id);
        
        // Delete image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully');
    }
}
