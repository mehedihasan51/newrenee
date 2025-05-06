<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Ajax\ImageController;
use App\Http\Controllers\Web\Ajax\CommitmentController;
use App\Http\Controllers\Web\Ajax\SubcategoryController;

Route::get('/subcategory/{category_id}', [SubcategoryController::class, 'index'])->name('subcategory');



Route::middleware(['auth'])->controller(ImageController::class)->prefix('image')->name('image.')->group(function () {
    Route::get('/{post_id}', 'index')->name('index');
    Route::get('/delete/{id}', 'destroy')->name('destroy');
});