<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ExpertQuote;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        $sliders = Slider::with('media')
            ->active()
            ->orderBy('position', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
        // Featured products for "Check Another Product" section (all featured products regardless of category)
        $products = Product::with(['category', 'media'])
            ->published()
            ->featured()
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Phytosync series products
        $phytosyncProducts = Product::with(['category', 'media'])
            ->published()
            ->whereHas('category', function ($query) {
                $query->where('name', 'Beautylatory');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Get 2 latest articles for editorial section
        $editorialArticles = Article::published()
            ->with(['author', 'categories', 'media'])
            ->latest('published_at')
            ->take(2)
            ->get();

        // Get 3 articles for Skin Talks section
        $articles = Article::published()
            ->with(['author', 'categories', 'tags', 'media'])
            ->latest('published_at')
            ->take(3)
            ->get();

        $expertQuote = ExpertQuote::query()
            ->with('media')
            ->active()
            ->first();

        return view('home.index', compact('sliders', 'products', 'phytosyncProducts', 'editorialArticles', 'articles', 'expertQuote'));
    }

    /**
     * Display the terms and conditions page.
     */
    public function terms(): View
    {
        return view('home.terms');
    }

    /**
     * Display the contact page.
     */
    public function contact(): View
    {
        return view('home.contact');
    }
}
