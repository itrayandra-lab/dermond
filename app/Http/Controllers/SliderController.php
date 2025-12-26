<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Slider::with(['media', 'product.media']);

        $search = $request->string('search')->trim();
        $status = $request->string('status')->trim();
        $hasImage = $request->string('has_image')->trim();

        if ($search->isNotEmpty()) {
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('label', 'like', '%'.$search.'%');
            });
        }

        if ($status->isNotEmpty() && in_array($status->toString(), ['draft', 'active', 'archived'], true)) {
            $query->where('status', $status->toString());
        }

        if ($hasImage->isNotEmpty() && in_array($hasImage->toString(), ['with', 'without'], true)) {
            if ($hasImage->toString() === 'with') {
                $query->whereHas('media', function ($mediaQuery) {
                    $mediaQuery->where('collection_name', 'slider_images');
                });
            } else {
                $query->whereDoesntHave('media', function ($mediaQuery) {
                    $mediaQuery->where('collection_name', 'slider_images');
                });
            }
        }

        $sliders = $query
            ->orderBy('position', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate(15)
            ->appends($request->query());

        return view('admin.slider.index', [
            'sliders' => $sliders,
            'filters' => [
                'search' => $search->toString(),
                'status' => $status->toString(),
                'has_image' => $hasImage->toString(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.slider.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB
            'label' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'cta_text' => 'nullable|string|max:50',
            'cta_link' => 'nullable|url|max:255',
            'product_id' => 'nullable|exists:products,id',
            'badge_title' => 'nullable|string|max:100',
            'badge_subtitle' => 'nullable|string|max:100',
            'position' => 'required|integer|min:1|unique:sliders,position',
            'status' => 'required|in:draft,active,archived',
        ]);

        $slider = Slider::create([
            'label' => $request->label,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'product_id' => $request->product_id ?: null,
            'badge_title' => $request->badge_title,
            'badge_subtitle' => $request->badge_subtitle,
            'position' => $request->position,
            'status' => $request->status,
        ]);

        // Handle image upload via Media Library
        if ($request->hasFile('image')) {
            $slider->addMediaFromRequest('image')
                ->toMediaCollection('slider_images');
        }

        return redirect()->route('admin.slider.index')->with('success', 'Slider item created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $slider = Slider::findOrFail($id);

        return view('admin.slider.form', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB
            'label' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'cta_text' => 'nullable|string|max:50',
            'cta_link' => 'nullable|url|max:255',
            'product_id' => 'nullable|exists:products,id',
            'badge_title' => 'nullable|string|max:100',
            'badge_subtitle' => 'nullable|string|max:100',
            'position' => 'required|integer|min:1|unique:sliders,position,'.$slider->id,
            'status' => 'required|in:draft,active,archived',
        ]);

        $sliderData = [
            'label' => $request->label,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'product_id' => $request->product_id ?: null,
            'badge_title' => $request->badge_title,
            'badge_subtitle' => $request->badge_subtitle,
            'position' => $request->position,
            'status' => $request->status,
        ];

        $slider->update($sliderData);

        // Handle image upload via Media Library (auto-replaces via singleFile())
        if ($request->hasFile('image')) {
            $slider->addMediaFromRequest('image')
                ->toMediaCollection('slider_images');
        }

        return redirect()->route('admin.slider.index')->with('success', 'Slider item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $slider = Slider::findOrFail($id);

        // Media files automatically deleted via model relationship
        $slider->delete();

        return redirect()->route('admin.slider.index')->with('success', 'Slider item deleted successfully.');
    }
}
