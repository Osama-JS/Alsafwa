<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        // Stats
        $stats = [
            'total'     => Partner::count(),
            'active'    => Partner::where('status', 'active')->count(),
            'inactive'  => Partner::where('status', 'inactive')->count(),
        ];

        // Filtering
        $query = Partner::query();

        if ($request->filled('search')) {
            $query->whereAny(['name_ar', 'name_en'], 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $partners = $query->orderBy('order')->paginate(15);

        return view('admin.partners.index', compact('partners', 'stats'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'logo'    => 'required|image|max:2048',
            'url'     => 'nullable|url|max:255',
            'status'  => 'required|in:active,inactive',
            'order'   => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        Partner::create($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'تم إضافة الشريك بنجاح');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'logo'    => 'nullable|image|max:2048',
            'url'     => 'nullable|url|max:255',
            'status'  => 'required|in:active,inactive',
            'order'   => 'nullable|integer',
        ]);

        $validated['updated_by'] = Auth::id();

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'تم تحديث بيانات الشريك بنجاح');
    }

    public function destroy(Partner $partner)
    {
        try {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }

            $partner->delete();

            return redirect()->route('admin.partners.index')
                ->with('success', 'تم حذف الشريك بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('admin.partners.index')
                ->with('error', 'عذراً، لا يمكن حذف هذا الشريك لارتباطه ببيانات أخرى.');
        }
    }
}
