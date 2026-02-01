<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\MasterclassController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Каталог мастер-классов
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');

// Детальная страница мастер-класса
Route::get('/masterclass/{id}', [MasterclassController::class, 'show'])->name('masterclass.show');

// Временные маршруты (будут реализованы позже)
Route::get('/login', function () {
    return view('welcome');
})->name('login');

Route::get('/register', function () {
    return view('welcome');
})->name('register');

Route::get('/masters', function () {
    return view('welcome');
})->name('masters');

Route::get('/blog', function () {
    return view('welcome');
})->name('blog');
