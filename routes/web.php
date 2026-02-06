<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CatalogController;
use App\Http\Controllers\Front\MasterclassController;
use App\Http\Controllers\Author\AuthController;
use App\Http\Controllers\Author\DashboardController as AuthorDashboardController;
use App\Http\Controllers\Author\MasterclassController as AuthorMasterclassController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Каталог мастер-классов
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');

// Детальная страница мастер-класса
Route::get('/masterclass/{id}', [MasterclassController::class, 'show'])->name('masterclass.show');

// Временные маршруты (будут реализованы позже)
Route::get('/login', function () {
    return view('front.home');
})->name('login');

Route::get('/register', function () {
    return view('front.home');
})->name('register');

Route::get('/masters', function () {
    return view('front.home');
})->name('masters');

Route::get('/blog', function () {
    return view('front.home');
})->name('blog');

// Author Admin Routes
Route::prefix('author')->name('author.')->group(function () {
    // Authentication Routes (без middleware)
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
    
    // Защищённые маршруты (требуют авторизации)
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AuthorDashboardController::class, 'index'])->name('dashboard');
        
        // Masterclass Management
        Route::prefix('masterclasses')->name('masterclasses.')->group(function () {
            Route::get('/', [AuthorMasterclassController::class, 'index'])->name('index');
            Route::get('/create', [AuthorMasterclassController::class, 'create'])->name('create');
            Route::post('/', [AuthorMasterclassController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AuthorMasterclassController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AuthorMasterclassController::class, 'update'])->name('update');
            Route::post('/{id}/publish', [AuthorMasterclassController::class, 'publish'])->name('publish');
            Route::delete('/{id}', [AuthorMasterclassController::class, 'destroy'])->name('destroy');
        });
        
        // TODO: Add more author routes
        Route::get('/notifications', function () {
            return view('author.dashboard');
        })->name('notifications');
    });
});

// Front Pages (временные заглушки для footer)
Route::name('front.')->group(function () {
    Route::view('/about', 'front.home')->name('about');
    Route::view('/terms', 'front.home')->name('terms');
    Route::view('/privacy', 'front.home')->name('privacy');
    Route::view('/help', 'front.home')->name('help');
});
