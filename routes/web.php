<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Stores\LoginController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/register', function () {
    return view('auth.register');
}); 

Route::get('/', [HomeController::class, 'index']);
Route::get('products/{slug}/', [ProductsController::class, 'show'])->name('products.show');

Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::post('cart', [CartController::class, 'store']);

Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('checkout', [CheckoutController::class, 'store']);



Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
// require __DIR__.'/auth.php';

Route::get('/stores/login', [LoginController::class, 'create'])
                
                ->name('stores.login');
Route::post('/stores/login', [LoginController::class, 'store'])
                ;

Route::namespace('Admin')
    ->prefix('admin')
    ->as('admin.')
    
    ->group(function() {
        
        /* Route::group([
            'prefix' => 'categories',
            'as' => 'categories.',
        ], function() {
            // admin.categories.index
            Route::get('/', 'CategoriesController@index')->name('index');
            // admin.categories.create
            Route::get('/create', 'CategoriesController@create')->name('create');
            Route::get('/{id}', 'CategoriesController@show')->name('show');
            Route::post('/', [CategoriesController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CategoriesController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CategoriesController::class, 'update'])->name('update');
            Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('destroy');
        }); */


        Route::get('categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
        Route::put('categories/trash/{id}', [CategoriesController::class, 'restore'])->name('categories.restore');
        Route::delete('categories/trash/{id}', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');


        Route::resources([
            'categories' => 'CategoriesController',
            'products' => 'ProductsController',
            'roles' => 'RolesController'
        ]);

        /* Route::resource('categories', 'categoriesController');
        
        Route::resource('products', 'ProductsController')->names([
            'index' => 'products.index',
        ]);

        Route::resource('roles', 'RolesController'); */
       
    });

//Route::resource('admin/categories', 'Admin\CategoriesController');

Route::get('admin/tags/{id}/products', [TagsController::class, 'products']);

Route::get('admin/users/{id}', [UsersController::class, 'show'])->name('admin.users.show');

Route::prefix('admin/categories')
    ->namespace('Admin')
    ->as('admin.categories.')
    ->group(function() {
        
    });

Route::get('regexp', function() {

    $test = '059-1234567,059-2332,059-22222';
    $exp = '/^(059|056)\-?([0-9]{7})$/';

    $email = 'last-name_12@domain';
    $pattern = '/^[a-zA-Z0-9]+[a-zA-Z0-9\.\-_]*@[a-zA-Z0-9]+[a-zA-Z0-9\.\-]*[a-zA-Z]+$/';

    preg_match($pattern, $email, $matches);
    dd($matches);

});
