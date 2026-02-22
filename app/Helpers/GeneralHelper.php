<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        $settings = Cache::rememberForever('settings', function () {
            return Setting::all()->pluck('value', 'key');
        });

        $value = $settings->get($key);

        return (!is_null($value) && $value !== '') ? $value : $default;
    }
}
