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

        return view('bundles.show', compact('bundle'));
    }
}
