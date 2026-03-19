<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
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

    public function show($id)
    {
        $distributor = Distributor::active()
            ->with(['products' => function($q) {
                $q->active()->orderBy('order');
            }])
            ->findOrFail($id);

        return view('frontend.distributors.show', compact('distributor'));
    }
}
