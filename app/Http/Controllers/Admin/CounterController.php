<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index()
    {
        $counters = Counter::orderBy('order')->paginate(15);
        return view('admin.counters.index', compact('counters'));
    }

    public function create()
    {
        return view('admin.counters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|max:255',
            'title_en' => 'required|max:255',
            'value' => 'required|integer',
            'icon' => 'nullable|max:100',
            'order' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        Counter::create($validated);

        return redirect()->route('admin.counters.index')
            ->with('success', 'تم إضافة العداد بنجاح');
    }

    public function edit(Counter $counter)
    {
        return view('admin.counters.edit', compact('counter'));
    }

    public function update(Request $request, Counter $counter)
    {
        $validated = $request->validate([
            'title_ar' => 'required|max:255',
            'title_en' => 'required|max:255',
            'value' => 'required|integer',
            'icon' => 'nullable|max:100',
            'order' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        $counter->update($validated);

        return redirect()->route('admin.counters.index')
            ->with('success', 'تم تحديث العداد بنجاح');
    }

    public function destroy(Counter $counter)
    {
        $counter->delete();
        return redirect()->route('admin.counters.index')
            ->with('success', 'تم حذف العداد بنجاح');
    }
}
