<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Отобразить главную страницу
     */
    public function index()
    {
        // TODO: Добавить логику загрузки популярных мастер-классов
        // Пример будущей реализации:
        // $popularClasses = MasterClass::popular()->limit(8)->get();
        // $topMasters = Master::topRated()->limit(6)->get();
        // $categories = Category::withCount('masterClasses')->get();
        
        return view('front.home');
    }
}
