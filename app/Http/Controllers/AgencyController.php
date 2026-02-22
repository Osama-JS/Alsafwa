<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::where('status', 'published')->orderBy('order')->paginate(12);
        return view('frontend.agencies.index', compact('agencies'));
    }
}
