<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributor::active()
            ->orderBy('order')
            ->paginate(12);

        return view('frontend.distributors.index', compact('distributors'));
    }

    public function show(Request $request, $id)
    {
        $distributor = Distributor::active()
            ->with(['products' => function($q) use ($request) {
                $q->active()->with('productCategory')->orderBy('order');
                if ($request->filled('category_id')) {
                    $q->where('product_category_id', $request->category_id);
                }
            }])
            ->findOrFail($id);

        $categories = ProductCategory::whereHas('products', function($q) use ($distributor) {
            $q->whereHas('distributors', function($dq) use ($distributor) {
                $dq->where('distributor_id', $distributor->id);
            })->active();
        })->where('status', 'active')->orderBy('order')->get();

        return view('frontend.distributors.show', compact('distributor', 'categories'));
    }
}
