<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::where('status', 'published')->orderBy('order')->get();
        return view('frontend.branches.index', compact('branches'));
    }
}
