<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        // Stats
        $stats = [
            'total' => Activity::count(),
            'published' => Activity::where('status', 'published')->count(),
            'draft' => Activity::where('status', 'draft')->count(),
        ];

        // Filtering
        $query = Activity::with('category');

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

        if ($request->filled('category_id')) {
            $query->where('activity_category_id', $request->category_id);
        }

        $activities = $query->orderBy('order')->paginate(10);
        $categories = ActivityCategory::where('status', 1)->get(); // For filter dropdown

        return view('admin.activities.index', compact('activities', 'stats', 'categories'));
    }

    public function create()
    {
        $categories = ActivityCategory::where('status', 1)->get();
        return view('admin.activities.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'activity_category_id' => 'nullable|exists:activity_categories,id',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'video_url' => 'nullable|url',
            'status' => 'required|in:published,draft,archived',
            'order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($request->title_en ?? $request->title_ar);

        $count = Activity::where('slug', $validated['slug'])->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('activities', 'public');
        }

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        Activity::create($validated);

        return redirect()->route('admin.activities.index')
            ->with('success', 'تم إضافة النشاط بنجاح');
    }

    public function edit(Activity $activity)
    {
        $categories = ActivityCategory::where('status', 1)->get();
        return view('admin.activities.edit', compact('activity', 'categories'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'activity_category_id' => 'nullable|exists:activity_categories,id',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
            'status' => 'required|in:published,draft,archived',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($activity->image) {
                Storage::disk('public')->delete($activity->image);
            }
            $validated['image'] = $request->file('image')->store('activities', 'public');
        }

        $validated['updated_by'] = Auth::id();

        $activity->update($validated);

        return redirect()->route('admin.activities.index')
            ->with('success', 'تم تحديث النشاط بنجاح');
    }

    public function destroy(Activity $activity)
    {
        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
        }

        $activity->delete();
        return redirect()->route('admin.activities.index')
            ->with('success', 'تم حذف النشاط بنجاح');
    }
}
