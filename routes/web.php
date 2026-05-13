<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{CategoryController, ItemController};

Route::get('/', function () {
    return view('welcome');
});

// Category
Route::get('/categories', [CategoryController::class,'index'])->name('category.index');
Route::post('/categories', [CategoryController::class,'store'])->name('category.store');
Route::get('/categories/{param}', [CategoryController::class,'show'])->name('category.show');
Route::put('/categories/{param}', [CategoryController::class,'update'])->name('category.update');
Route::delete('/categories/{param}', [CategoryController::class,'destroy'])->name('category.destroy');

// items
Route::get('/items', [ItemController::class,'index'])->name('item.index');
Route::post('/items', [ItemController::class,'store'])->name('item.store');
Route::get('/items/{param}', [ItemController::class,'show'])->name('item.show');
Route::put('/items/{param}', [ItemController::class,'update'])->name('item.update');
Route::delete('/items/{param}', [ItemController::class,'destroy'])->name('item.destroy');


// trash category dan items
Route::get('/trash/categories', [CategoryController::class,'trash'])->name('category.trash');
Route::patch('/restore/categories/{param}', [CategoryController::class,'restore'])->name('category.restore');
Route::delete('/force-delete/categories/{param}', [CategoryController::class,'force'])->name('category.force');

Route::get('/trash/items', [ItemController::class,'trash'])->name('item.trash');
Route::patch('/restore/items/{param}', [ItemController::class,'restore'])->name('item.restore');
Route::delete('/force-delete/items/{param}', [ItemController::class,'force'])->name('item.force');


