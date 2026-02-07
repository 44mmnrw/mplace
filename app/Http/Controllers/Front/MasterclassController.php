<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class MasterclassController extends Controller
{
    /**
     * Display the masterclass detail page.
     */
    public function show($id)
    {
        // Загрузка мастер-класса со всеми связями
        $product = Product::with([
            'author',
            'images' => fn($q) => $q->orderBy('sort_order'),
            'mainImage',
            'activePrice',
            'difficultyLevel',
            'primaryCategory',
            'reviews' => fn($q) => $q->with('user')->latest()->limit(5),
        ])
        ->where('status', 'published')
        ->findOrFail($id);

        // Другие мастер-классы автора (исключая текущий)
        $authorClasses = Product::where('author_id', $product->author_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->with(['mainImage', 'activePrice'])
            ->limit(4)
            ->get();

        // Похожие мастер-классы (из той же категории)
        $similarClasses = Product::whereHas('categories', function($q) use ($product) {
                if ($product->primaryCategory) {
                    $q->where('categories.id', $product->primaryCategory->id);
                }
            })
            ->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->with(['author', 'mainImage', 'activePrice'])
            ->limit(4)
            ->get();
        
        return view('front.masterclass-detail', compact('product', 'authorClasses', 'similarClasses'));
    }
}
