<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Service;
use App\Models\Partner;
use App\Models\Page;

class HomeController extends Controller
{
    public function index()
    {
        // Normalize old 'published'/'draft' statuses to new 'active'/'inactive'
        Slider::where('status', 'published')->update(['status' => 'active']);
        Slider::where('status', 'draft')->update(['status' => 'inactive']);

        $sliders = Slider::where('status', 'active')
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

        $partners = Partner::where('status', 'active')
            ->orderBy('order')
            ->get();

        return view('frontend.home', compact('sliders', 'services', 'agencies', 'activities', 'about', 'counters', 'products', 'partners'));
    }

    public function about()
    {
        $page = Page::where('slug', 'about-us')->firstOrFail();
        return view('frontend.page', compact('page'));
    }
}
