<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::where('status', 'active')->orderBy('order')->get();

        $products = Product::active()
            ->with(['agency', 'productCategory'])
            ->when($request->category_id, function($q) use ($request) {
                $q->where('product_category_id', $request->category_id);
            })
            ->orderBy('order')
            ->paginate(12);

        return view('frontend.products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::with(['distributors', 'agency', 'productCategory'])->where('slug', $slug)->firstOrFail();
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
