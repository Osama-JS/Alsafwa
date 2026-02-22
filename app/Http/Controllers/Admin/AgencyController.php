<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        // Stats
        $stats = [
            'total' => Agency::count(),
            'published' => Agency::where('status', 'published')->count(),
            'draft' => Agency::where('status', 'draft')->count(),
        ];

        // Filtering
        $query = Agency::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $agencies = $query->orderBy('order')->paginate(10);
        return view('admin.agencies.index', compact('agencies', 'stats'));
    }

    public function create()
    {
        return view('admin.agencies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'logo' => 'required|image|max:2048',
            'website' => 'nullable|url',
            'status' => 'required|in:published,draft,archived',
            'order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($request->name_en ?? $request->name_ar);

        // Ensure unique slug
        $count = Agency::where('slug', $validated['slug'])->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('agencies', 'public');
        }

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        Agency::create($validated);

        return redirect()->route('admin.agencies.index')
            ->with('success', 'تم إضافة الوكالة بنجاح');
    }

    public function edit(Agency $agency)
    {
        return view('admin.agencies.edit', compact('agency'));
    }

    public function update(Request $request, Agency $agency)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url',
            'status' => 'required|in:published,draft,archived',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            if ($agency->logo) {
                Storage::disk('public')->delete($agency->logo);
            }
            $validated['logo'] = $request->file('logo')->store('agencies', 'public');
        }

        $validated['updated_by'] = Auth::id();

        $agency->update($validated);

        return redirect()->route('admin.agencies.index')
            ->with('success', 'تم تحديث الوكالة بنجاح');
    }

    public function destroy(Agency $agency)
    {
        if ($agency->logo) {
            Storage::disk('public')->delete($agency->logo);
        }

        $agency->delete();
        return redirect()->route('admin.agencies.index')
            ->with('success', 'تم حذف الوكالة بنجاح');
    }
}
