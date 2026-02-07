<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\DifficultyLevel;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Отобразить страницу каталога мастер-классов
     */
    public function index(Request $request)
    {
        $query = Product::query()
            ->where('status', 'published')
            ->with(['author', 'mainImage', 'primaryCategory', 'activePrice', 'difficultyLevel']);

        // Фильтр по уровню сложности
        if ($request->has('level') && is_array($request->level)) {
            $query->whereHas('difficultyLevel', function($q) use ($request) {
                $q->whereIn('slug', $request->level);
            });
        }

        // Фильтр по категории
        if ($request->has('category')) {
            $query->where('primary_category_id', $request->category);
        }

        // Фильтр по цене
        if ($request->has('price_min')) {
            $query->whereHas('activePrice', function($q) use ($request) {
                $q->where('price', '>=', $request->price_min);
            });
        }
        if ($request->has('price_max')) {
            $query->whereHas('activePrice', function($q) use ($request) {
                $q->where('price', '<=', $request->price_max);
            });
        }

        // Фильтр по скидке
        if ($request->has('discount') && $request->discount === 'yes') {
            $query->whereHas('activePrice', function($q) {
                $q->whereNotNull('old_price');
            });
        }

        // Сортировка
        $sortBy = $request->get('sort', 'popular');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default: // popular
                $query->orderBy('sales_count', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $difficultyLevels = DifficultyLevel::orderBy('sort_order')->get();

        return view('front.catalog', compact('products', 'categories', 'difficultyLevels'));
    }
}
