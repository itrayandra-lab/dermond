<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BundleFormRequest;
use App\Models\Bundle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BundleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Bundle::with('media');

        $search = $request->string('search')->trim();

        if ($search->isNotEmpty()) {
            $query->where('name', 'like', '%'.$search.'%');
        }

        $bundles = $query->orderBy('created_at', 'desc')->paginate(15)->appends($request->query());

        return view('admin.bundles.index', compact('bundles'));
    }

    public function create(): View
    {
        $products = \App\Models\Product::published()->orderBy('name')->get(['id', 'name']);

        return view('admin.bundles.form', compact('products'));
    }

    public function store(BundleFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        unset($validated['images'], $validated['images_delete']);

        $bundle = Bundle::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $bundle->addMedia($image)->toMediaCollection('bundle_images');
            }
        }

        return redirect()->route('admin.bundles.index')->with('success', 'Bundle created successfully.');
    }

    public function edit(Bundle $bundle): View
    {
        $bundle->load('media');
        $products = \App\Models\Product::published()->orderBy('name')->get(['id', 'name']);

        return view('admin.bundles.form', compact('bundle', 'products'));
    }

    public function update(BundleFormRequest $request, Bundle $bundle): RedirectResponse
    {
        $validated = $request->validated();
        unset($validated['images'], $validated['images_delete']);

        $bundle->update($validated);

        // Delete selected images
        if ($request->filled('images_delete')) {
            foreach ($request->input('images_delete') as $mediaId) {
                $bundle->deleteMedia($mediaId);
            }
        }

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $bundle->addMedia($image)->toMediaCollection('bundle_images');
            }
        }

        return redirect()->route('admin.bundles.index')->with('success', 'Bundle updated successfully.');
    }

    public function destroy(Bundle $bundle): RedirectResponse
    {
        $bundle->clearMediaCollection('bundle_images');
        $bundle->delete();

        return redirect()->route('admin.bundles.index')->with('success', 'Bundle deleted successfully.');
    }
}
