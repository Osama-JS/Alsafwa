<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index(Request $request)
    {
        // Stats
        $stats = [
            'total' => Page::count(),
            'published' => Page::where('status', 'published')->count(),
            'draft' => Page::where('status', 'draft')->count(),
        ];

        // Filtering
        $query = Page::query();

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

        $pages = $query->latest()->paginate(15);
        return view('admin.pages.index', compact('pages', 'stats'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|max:255',
            'title_en' => 'required|max:255',
            'content_ar' => 'required',
            'content_en' => 'required',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:published,draft',
            'order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($request->title_en);
        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('pages', 'public');
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'تم إنشاء الصفحة بنجاح');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title_ar' => 'required|max:255',
            'title_en' => 'required|max:255',
            'content_ar' => 'required',
            'content_en' => 'required',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:published,draft',
            'order' => 'nullable|integer',
        ]);

        $validated['updated_by'] = auth()->id();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $validated['image'] = $request->file('image')->store('pages', 'public');
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'تم تحديث الصفحة بنجاح');
    }

    public function destroy(Page $page)
    {
        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }

        $page->delete();
        return redirect()->route('admin.pages.index')
            ->with('success', 'تم حذف الصفحة بنجاح');
    }
}
