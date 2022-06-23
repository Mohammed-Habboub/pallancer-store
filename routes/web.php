<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;




// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', [DashboardController::class, 'index']);
// Method 1
Route::group([
        'prefix'    => 'admin/categories',
        'namespace' => 'Admin',
        'as'        => 'admin.categories.',
    ], function() {
        // admin.categories.index                
        Route::get('/', 'CategoriesController@index')->name('index');
        // admin.categoryies.create
        Route::get('/create', [CategoriesController::class, 'create'])->name('create');

        Route::get('/{id}', [CategoriesController::class, 'show'])->name('show');

        Route::post('/create', [CategoriesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoriesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoriesController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('destroy');

    });


   // Route::resource('admin/categories', 'Admin\CategoriesController');
    // Method 2
    /* Route::prefix('admin/categories')
        ->namespace('Admin')
        ->as('admin.categories.')
        ->group(function () {

        }); */
    
