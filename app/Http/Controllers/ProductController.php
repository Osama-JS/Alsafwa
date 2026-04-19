<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Agency;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Get only main categories with their active sub-categories
        $categories = ProductCategory::whereNull('parent_id')
            ->where('status', 'active')
            ->with(['children' => function($q) {
                $q->where('status', 'active')->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        // Get active agencies for filtering
        $agencies = Agency::published()->orderBy('name_ar')->get();

        // Query setup
        $query = Product::active()->with(['agency', 'productCategory']);

        // Apply filters for AJAX requests OR when navigating from the navbar
        if ($request->ajax() || $request->wantsJson() || $request->has('navbar')) {
            // 1. Hierarchical Category Filter (Supports Multi-select)
            if ($request->filled('category_id')) {
                $catIds = (array) $request->category_id;
                $allCategoryIds = [];
                foreach ($catIds as $id) {
                    $category = ProductCategory::with('children')->find($id);
                    if ($category) {
                        $allCategoryIds[] = $category->id;
                        if ($category->children->count() > 0) {
                            $allCategoryIds = array_merge($allCategoryIds, $category->children->pluck('id')->toArray());
                        }
                    }
                }
                if (!empty($allCategoryIds)) {
                    $query->whereIn('product_category_id', array_unique($allCategoryIds));
                }
            }

            // 2. Agency Filter (Supports Multi-select)
            if ($request->filled('agency_id')) {
                $agencyIds = (array) $request->agency_id;
                $query->whereIn('agency_id', $agencyIds);
            }

            // 3. Search Filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title_ar', 'like', "%{$search}%")
                    ->orWhere('title_en', 'like', "%{$search}%");
                });
            }
        }

        $products = $query->orderBy('order')->paginate(12);

        // AJAX Response (Enhanced detection)
        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') == 'XMLHttpRequest') {
            return response()->json([
                'html' => view('frontend.products._list', compact('products'))->render(),
                'pagination' => (string) $products->links(),
                'total' => $products->total()
            ]);
        }

        return view('frontend.products.index', compact('products', 'categories', 'agencies'));
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
