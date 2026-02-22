<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function index()
    {
        return view('docs.index');
    }

    public function userGuide()
    {
        return view('docs.user-guide');
    }

    public function developerGuide()
    {
        return view('docs.developer-guide');
    }
}
