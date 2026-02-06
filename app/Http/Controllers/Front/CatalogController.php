<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Отобразить страницу каталога мастер-классов
     */
    public function index(Request $request)
    {
        // TODO: Добавить логику фильтрации когда будут созданы модели
        // Пример будущей реализации:
        // $classes = MasterClass::query()
        //     ->when($request->level, fn($q) => $q->whereIn('level', $request->level))
        //     ->when($request->format, fn($q) => $q->whereIn('format', $request->format))
        //     ->when($request->theme, fn($q) => $q->whereIn('theme', $request->theme))
        //     ->when($request->price_min, fn($q) => $q->where('price', '>=', $request->price_min))
        //     ->when($request->price_max, fn($q) => $q->where('price', '<=', $request->price_max))
        //     ->paginate(12);
        
        return view('front.catalog');
    }
}
