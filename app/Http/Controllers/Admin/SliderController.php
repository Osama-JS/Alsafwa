<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        // Stats
        $stats = [
            'total' => Slider::count(),
            'published' => Slider::where('status', 'active')->count(),
            'draft' => Slider::where('status', 'inactive')->count(),
        ];

        // Filtering
        $query = Slider::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('subtitle_ar', 'like', "%{$search}%")
                  ->orWhere('subtitle_en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sliders = $query->orderBy('order')->paginate(10);
        return view('admin.sliders.index', compact('sliders', 'stats'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'subtitle_ar' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'image' => 'required|image|max:2048',
            'link' => 'nullable|url',
            'button_text_ar' => 'nullable|string|max:50',
            'button_text_en' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'تم إضافة الشريحة بنجاح');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'subtitle_ar' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
            'button_text_ar' => 'nullable|string|max:50',
            'button_text_en' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'تم تحديث الشريحة بنجاح');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();
        return redirect()->route('admin.sliders.index')
            ->with('success', 'تم حذف الشريحة بنجاح');
    }
}
