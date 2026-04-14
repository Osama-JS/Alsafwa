<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::withCount('products')->orderBy('order')->paginate(20);
        return view('admin.product_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'status'  => 'required|in:active,inactive',
            'order'   => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($request->name_en);

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $count = 1;
        while (ProductCategory::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "{$originalSlug}-{$count}";
            $count++;
        }

        ProductCategory::create($validated);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'تم إضافة القسم بنجاح ✓');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('admin.product_categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = ProductCategory::findOrFail($id);

        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'status'  => 'required|in:active,inactive',
            'order'   => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($request->name_en);

        // Ensure unique slug (excluding self)
        $originalSlug = $validated['slug'];
        $count = 1;
        while (ProductCategory::where('slug', $validated['slug'])->where('id', '!=', $category->id)->exists()) {
            $validated['slug'] = "{$originalSlug}-{$count}";
            $count++;
        }

        $category->update($validated);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'تم تحديث القسم بنجاح ✓');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = ProductCategory::findOrFail($id);

        if ($category->products()->count() > 0) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'لا يمكن حذف القسم لأنه يحتوي على منتجات. الرجاء نقل المنتجات أو حذفها أولاً.');
        }

        $category->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'تم حذف القسم بنجاح ✓');
    }
}
