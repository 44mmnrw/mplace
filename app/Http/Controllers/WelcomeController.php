<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
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
        
        return view('welcome');
    }
}
