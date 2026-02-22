<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('category')->where('status', 'published')->orderBy('order')->paginate(9);
        return view('frontend.activities.index', compact('activities'));
    }

    public function show($slug)
    {
        $activity = Activity::where('slug', $slug)->where('status', 'published')->firstOrFail();
        return view('frontend.activities.show', compact('activity'));
    }
}
