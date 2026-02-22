<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::active()
            ->with('agency')
            ->orderBy('order')
            ->paginate(12);

        return view('frontend.products.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->when($product->agency_id, function($q) use ($product) {
                $q->where('agency_id', $product->agency_id);
            })
            ->take(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }
}
