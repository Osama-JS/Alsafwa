<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::where('status', 1)->orderBy('order')->get();
        $images = GalleryImage::where('status', 'published')->orderBy('order')->paginate(12);

        return view('frontend.gallery.index', compact('images', 'categories'));
    }
}
