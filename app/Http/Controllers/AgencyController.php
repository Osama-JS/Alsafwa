<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::published()->orderBy('order')->paginate(12);
        return view('frontend.agencies.index', compact('agencies'));
    }

    public function show($slug)
    {
        $agency = Agency::published()
            ->with(['products' => function($q) {
                $q->active()->orderBy('order');
            }])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.agencies.show', compact('agency'));
    }
}
