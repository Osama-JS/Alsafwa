<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 'published')
            ->orderBy('order')
            ->paginate(12);

        return view('frontend.services.index', compact('services'));
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('frontend.services.show', compact('service'));
    }
}
