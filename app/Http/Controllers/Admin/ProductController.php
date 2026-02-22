<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total' => Product::count(),
            'active' => Product::where('status', 'active')->count(),
            'inactive' => Product::where('status', 'inactive')->count(),
        ];

        $query = Product::with('agency');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('order')->paginate(12);
        return view('admin.products.index', compact('products', 'stats'));
    }

    public function create()
    {
        $agencies = Agency::orderBy('name_ar')->get();
        return view('admin.products.create', compact('agencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'agency_id' => 'nullable|exists:agencies,id',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['title_en']) . '-' . Str::random(5);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function edit(Product $product)
    {
        $agencies = Agency::orderBy('name_ar')->get();
        return view('admin.products.edit', compact('product', 'agencies'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'agency_id' => 'nullable|exists:agencies,id',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
}
