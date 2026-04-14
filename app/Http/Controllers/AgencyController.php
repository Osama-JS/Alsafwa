<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::published()->orderBy('order')->paginate(12);
        return view('frontend.agencies.index', compact('agencies'));
    }

    public function show(Request $request, $slug)
    {
        $agency = Agency::published()
            ->with(['products' => function($q) use ($request) {
                $q->active()->with('productCategory')->orderBy('order');
                if ($request->filled('category_id')) {
                    $q->where('product_category_id', $request->category_id);
                }
            }])
            ->where('slug', $slug)
            ->firstOrFail();

        $categories = ProductCategory::whereHas('products', function($q) use ($agency) {
            $q->where('agency_id', $agency->id)->active();
        })->where('status', 'active')->orderBy('order')->get();

        return view('frontend.agencies.show', compact('agency', 'categories'));
    }
}
