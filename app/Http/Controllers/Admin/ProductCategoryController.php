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
        $categories = ProductCategory::with(['parent'])->withCount('products')->orderBy('order')->paginate(20);
        return view('admin.product_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = ProductCategory::whereNull('parent_id')->orderBy('name_ar')->get();
        return view('admin.product_categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar'   => 'required|string|max:255',
            'name_en'   => 'required|string|max:255',
            'parent_id' => 'nullable|exists:product_categories,id',
            'status'    => 'required|in:active,inactive',
            'order'     => 'nullable|integer',
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
        $parents = ProductCategory::whereNull('parent_id')
                    ->where('id', '!=', $id)
                    ->orderBy('name_ar')
                    ->get();
        return view('admin.product_categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = ProductCategory::findOrFail($id);

        $validated = $request->validate([
            'name_ar'   => 'required|string|max:255',
            'name_en'   => 'required|string|max:255',
            'parent_id' => 'nullable|exists:product_categories,id',
            'status'    => 'required|in:active,inactive',
            'order'     => 'nullable|integer',
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

        if ($category->children()->count() > 0) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'لا يمكن حذف القسم لأنه يحتوي على أقسام فرعية مرتبطة به. الرجاء حذف الأقسام الفرعية أو تغيير تبعيتها أولاً.');
        }

        $category->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'تم حذف القسم بنجاح ✓');
    }
}
