<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

// Category
Route::get('/categories', [CategoryController::class,'index'])->name('category.index');
Route::post('/categories', [CategoryController::class,'store'])->name('category.store');
Route::get('/categories/{param}', [CategoryController::class,'show'])->name('category.show');
Route::put('/categories/{param}', [CategoryController::class,'update'])->name('category.update');
Route::delete('/categories/{param}', [CategoryController::class,'destroy'])->name('category.destroy');

Route::get('/trash/categories', [CategoryController::class,'trash'])->name('category.trash');
Route::patch('/restore/categories/{param}', [CategoryController::class,'restore'])->name('category.restore');
Route::delete('/force-delete/categories/{param}', [CategoryController::class,'force'])->name('category.force');

