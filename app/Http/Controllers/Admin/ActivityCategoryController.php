<?php
// app/Http/Controllers/Admin/ActivityCategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ActivityCategory::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $categories = $query->orderBy('order')->paginate(10);
        
        return view('admin.activity_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.activity_categories.create');
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

        $validated['slug'] = Str::slug($validated['name_en']);
        
        // Ensure unique slug
        $count = ActivityCategory::where('slug', $validated['slug'])->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }

        ActivityCategory::create($validated);

        return redirect()->route('admin.activity-categories.index')
            ->with('success', 'تم إضافة التصنيف بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityCategory $activityCategory)
    {
        return view('admin.activity_categories.edit', compact('activityCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityCategory $activityCategory)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'status'  => 'required|in:active,inactive',
            'order'   => 'nullable|integer',
        ]);

        if ($activityCategory->name_en !== $validated['name_en']) {
             $validated['slug'] = Str::slug($validated['name_en']);
             $count = ActivityCategory::where('slug', $validated['slug'])
                ->where('id', '!=', $activityCategory->id)
                ->count();
             if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
             }
        }

        $activityCategory->update($validated);

        return redirect()->route('admin.activity-categories.index')
            ->with('success', 'تم تحديث التصنيف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityCategory $activityCategory)
    {
        try {
            // Activities will be deleted automatically due to CascadeOnDelete if set in migration
            // Let's check the migration again - yes it was cascadeOnDelete.
            $activityCategory->delete();
            return redirect()->route('admin.activity-categories.index')
                ->with('success', 'تم حذف التصنيف بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('admin.activity-categories.index')
                ->with('error', 'عذراً، لا يمكن حذف هذا التصنيف لارتباطه ببيانات أخرى.');
        }
    }
}
