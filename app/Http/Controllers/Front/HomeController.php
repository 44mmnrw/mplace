<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Отобразить главную страницу
     */
    public function index()
    {
        // Популярные мастер-классы (по продажам)
        $popularClasses = Product::where('status', 'published')
            ->with(['author', 'mainImage', 'primaryCategory', 'activePrice'])
            ->orderBy('sales_count', 'desc')
            ->limit(8)
            ->get();

        // Топ мастеров (по рейтингу)
        $topMasters = Author::withCount('products')
            ->orderBy('author_rating', 'desc')
            ->limit(6)
            ->get();

        // Категории с количеством товаров
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function($q) {
                $q->where('status', 'published');
            }])
            ->orderBy('sort_order')
            ->get();
        
        return view('front.home', compact('popularClasses', 'topMasters', 'categories'));
    }
}
