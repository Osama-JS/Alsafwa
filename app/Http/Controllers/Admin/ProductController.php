<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Agency;
use App\Models\ProductCategory;
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

        $query = Product::with(['agency', 'productCategory']);

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
        $categories = ProductCategory::where('status', 'active')->orderBy('name_ar')->get();
        return view('admin.products.create', compact('agencies', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'agency_id' => 'nullable|exists:agencies,id',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['title_en']) . '-' . Str::random(5);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('products/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function edit(Product $product)
    {
        $agencies = Agency::orderBy('name_ar')->get();
        $categories = ProductCategory::where('status', 'active')->orderBy('name_ar')->get();
        return view('admin.products.edit', compact('product', 'agencies', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'remove_gallery_images' => 'nullable|array',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'agency_id' => 'nullable|exists:agencies,id',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
        ]);

        // Handle Main Image
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle Gallery Deletions
        $currentGallery = $product->gallery ?? [];
        if ($request->filled('remove_gallery_images')) {
            foreach ($request->remove_gallery_images as $imgPath) {
                if (in_array($imgPath, $currentGallery)) {
                    Storage::disk('public')->delete($imgPath);
                    $currentGallery = array_values(array_diff($currentGallery, [$imgPath]));
                }
            }
        }

        // Handle Gallery New Uploads
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $currentGallery[] = $file->store('products/gallery', 'public');
            }
        }
        $validated['gallery'] = $currentGallery;

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            if ($product->gallery) {
                foreach ($product->gallery as $img) {
                    Storage::disk('public')->delete($img);
                }
            }

            $product->delete();
            return redirect()->route('admin.products.index')
                ->with('success', 'تم حذف المنتج بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'عذراً، لا يمكن حذف هذا المنتج لارتباطه ببيانات أخرى أو وجود خطأ في النظام.');
        }
    }
}
