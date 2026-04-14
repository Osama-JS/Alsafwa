<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::orderBy('order')->paginate(10);
        return view('admin.gallery_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.gallery_categories.create');
    }

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
        $count = GalleryCategory::where('slug', 'like', $validated['slug'] . '%')->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }

        GalleryCategory::create($validated);

        return redirect()->route('admin.gallery-categories.index')
            ->with('success', 'تم إضافة القسم بنجاح');
    }

    public function edit($id)
    {
        $category = GalleryCategory::findOrFail($id);
        return view('admin.gallery_categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = GalleryCategory::findOrFail($id);

        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'status'  => 'required|in:active,inactive',
            'order'   => 'nullable|integer',
        ]);

        if ($request->name_en !== $category->name_en) {
            $validated['slug'] = Str::slug($request->name_en);
            $count = GalleryCategory::where('slug', 'like', $validated['slug'] . '%')
                    ->where('id', '!=', $id)
                    ->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        }

        $category->update($validated);

        return redirect()->route('admin.gallery-categories.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy($id)
    {
        $category = GalleryCategory::findOrFail($id);
        
        if ($category->images()->count() > 0) {
            return redirect()->route('admin.gallery-categories.index')
                ->with('error', 'لا يمكن حذف القسم لوجود صور مرتبطة به.');
        }

        $category->delete();

        return redirect()->route('admin.gallery-categories.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }
}
