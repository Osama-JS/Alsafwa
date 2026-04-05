<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DistributorController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total'     => Distributor::count(),
            'active'    => Distributor::where('status', 'active')->count(),
            'inactive'  => Distributor::where('status', 'inactive')->count(),
        ];

        $query = Distributor::query();

        if ($request->filled('search')) {
            $query->whereAny(['name_ar', 'name_en'], 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $distributors = $query->orderBy('order')->paginate(15);

        return view('admin.distributors.index', compact('distributors', 'stats'));
    }

    public function create()
    {
        $products = Product::active()->get();
        return view('admin.distributors.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'address_ar' => 'nullable|max:255',
            'address_en' => 'nullable|max:255',
            'description_ar' => 'nullable',
            'description_en' => 'nullable',
            'logo'    => 'required|image|max:2048',
            'url'     => 'nullable|url|max:255',
            'phone'   => 'nullable|max:20',
            'map_url' => 'nullable',
            'status'  => 'required|in:active,inactive',
            'order'   => 'nullable|integer',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('distributors', 'public');
        }

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $distributor = Distributor::create($validated);

        if ($request->has('products')) {
            $distributor->products()->sync($request->products);
        }

        return redirect()->route('admin.distributors.index')
            ->with('success', 'تم إضافة الموزع بنجاح');
    }

    public function edit(Distributor $distributor)
    {
        $products = Product::active()->get();
        $distributorProducts = $distributor->products()->pluck('products.id')->toArray();
        return view('admin.distributors.edit', compact('distributor', 'products', 'distributorProducts'));
    }

    public function update(Request $request, Distributor $distributor)
    {
        $validated = $request->validate([
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'address_ar' => 'nullable|max:255',
            'address_en' => 'nullable|max:255',
            'description_ar' => 'nullable',
            'description_en' => 'nullable',
            'logo'    => 'nullable|image|max:2048',
            'url'     => 'nullable|url|max:255',
            'phone'   => 'nullable|max:20',
            'map_url' => 'nullable',
            'status'  => 'required|in:active,inactive',
            'order'   => 'nullable|integer',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $validated['updated_by'] = Auth::id();

        if ($request->hasFile('logo')) {
            if ($distributor->logo) {
                Storage::disk('public')->delete($distributor->logo);
            }
            $validated['logo'] = $request->file('logo')->store('distributors', 'public');
        }

        $distributor->update($validated);

        if ($request->has('products')) {
            $distributor->products()->sync($request->products);
        } else {
            $distributor->products()->detach();
        }

        return redirect()->route('admin.distributors.index')
            ->with('success', 'تم تحديث بيانات الموزع بنجاح');
    }

    public function destroy(Distributor $distributor)
    {
        try {
            if ($distributor->logo) {
                Storage::disk('public')->delete($distributor->logo);
            }

            $distributor->products()->detach();
            $distributor->delete();

            return redirect()->route('admin.distributors.index')
                ->with('success', 'تم حذف الموزع بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('admin.distributors.index')
                ->with('error', 'عذراً، لا يمكن حذف هذا الموزع لارتباطه ببيانات أخرى.');
        }
    }
}
