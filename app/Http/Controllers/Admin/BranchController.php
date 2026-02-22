<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        // Stats
        $stats = [
            'total' => Branch::count(),
            'published' => Branch::where('status', 1)->count(), // boolean status
            'draft' => Branch::where('status', 0)->count(),
        ];

        // Filtering
        $query = Branch::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address_ar', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $branches = $query->orderBy('order')->paginate(10);
        return view('admin.branches.index', compact('branches', 'stats'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address_ar' => 'required|string',
            'address_en' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'working_hours_ar' => 'nullable|string',
            'working_hours_en' => 'nullable|string',
            'map_url' => 'nullable|url',
            'status' => 'required|in:published,draft',
            'order' => 'nullable|integer',
        ]);

        Branch::create($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'تم إضافة الفرع بنجاح');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address_ar' => 'required|string',
            'address_en' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'working_hours_ar' => 'nullable|string',
            'working_hours_en' => 'nullable|string',
            'map_url' => 'nullable|url',
            'status' => 'required|in:published,draft',
            'order' => 'nullable|integer',
        ]);

        $branch->update($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'تم تحديث الفرع بنجاح');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('admin.branches.index')
            ->with('success', 'تم حذف الفرع بنجاح');
    }
}
