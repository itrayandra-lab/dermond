<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
        $sliders = Slider::with(['media', 'product.category', 'product.media'])
            ->active()
            ->orderBy('position', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
            
        // Featured products for "THE ULTIMATE COLLECTION" section
        $featuredProducts = Product::with(['category', 'media'])
            ->published()
            ->featured()
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // All published products for "PRODUCTS" section
        $products = Product::with(['category', 'media'])
            ->published()
            ->orderBy('created_at', 'desc')
            ->limit(6)
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

        return view('home.index', compact('sliders', 'products', 'featuredProducts', 'editorialArticles', 'articles'));
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
