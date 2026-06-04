<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\View\View;

class BundleController extends Controller
{
    public function show(Bundle $bundle): View
    {
        abort_if($bundle->status !== 'published', 404);

        $bundle->load('media');

        // Load actual products from DB if product_ids stored
        $productIds = $bundle->product_ids ?? [];
        $products = collect();
        if (! empty($productIds)) {
            $products = \App\Models\Product::with(['category', 'media'])
                ->published()
                ->whereIn('id', $productIds)
                ->get();
        }

        return view('bundles.show', compact('bundle', 'products'));
    }
}
