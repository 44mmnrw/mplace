<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Отобразить панель управления автора
     */
    public function index()
    {
        $author = auth()->user()->author;
        
        return view('author.dashboard', compact('author'));
    }
}
