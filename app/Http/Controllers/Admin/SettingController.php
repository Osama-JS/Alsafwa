<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Handle file uploads
            if ($request->hasFile($key)) {
                $setting = Setting::where('key', $key)->first();
                // Delete old file if exists
                if ($setting && $setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }
                $value = $request->file($key)->store('settings', 'public');
            }

            Setting::where('key', $key)->update(['value' => $value]);
        }

        // Clear settings cache
        Cache::forget('settings');
        Cache::forget('site_settings');

        return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح ✓');
    }
}
