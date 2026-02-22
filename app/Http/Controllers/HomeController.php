<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Service;
use App\Models\Broadcast; // Assuming we might use this later, but for now logic is simpler
use App\Models\Page;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::whereIn('status', ['active', 'published'])
            ->orderBy('order')
            ->get();

        $services = Service::where('status', 'published')
            ->orderBy('order')
            ->take(6)
            ->get();

        $agencies = \App\Models\Agency::where('status', 'published')
            ->orderBy('order')
            ->get();

        $activities = \App\Models\Activity::where('status', 'published')
            ->orderBy('order')
            ->take(3)
            ->get();

        $about = Page::where('slug', 'about-us')
            ->where('status', 'published')
            ->first();

        $counters = \App\Models\Counter::where('status', 'active')
            ->orderBy('order')
            ->get();

        $products = \App\Models\Product::where('status', 'active')
            ->with('agency')
            ->orderBy('order')
            ->take(8)
            ->get();

        return view('frontend.home', compact('sliders', 'services', 'agencies', 'activities', 'about', 'counters', 'products'));
    }

    public function about()
    {
        $page = Page::where('slug', 'about-us')->firstOrFail();
        return view('frontend.page', compact('page'));
    }
}
