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


Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:web,store'])->name('dashboard');
// require __DIR__.'/auth.php';

Route::get('/stores/login', [LoginController::class, 'create'])
                ->middleware('guest:store')
                ->name('stores.login');
Route::post('/stores/login', [LoginController::class, 'store'])
                ->middleware('guest:store');

                Route::namespace('Admin')
                ->prefix('admin')
                ->as('admin.')
                ->middleware('auth', 'user.type:super-admin,admin,store')
                ->group(function() {
            
                    Route::get('notifications', [NotificationsController::class, 'index'])->name('notifications');
            
                    Route::get('orders/{order}/print', [OrdersController::class, 'print']);
                    
                    /*Route::group([
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
                    });*/
            
                    Route::get('categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
                    Route::put('categories/trash/{id}', [CategoriesController::class, 'restore'])->name('categories.restore');
                    Route::delete('categories/trash/{id}', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');
                    
            
                    Route::get('products/export', 'ProductsController@export')
                        ->name('products.export');
                    Route::get('products/import', 'ProductsController@importView')
                        ->name('products.import');
                    Route::post('products/import', 'ProductsController@import');
            
            
                    Route::resources([
                        'categories' => 'CategoriesController',
                        'products' => 'ProductsController',
                        'roles' => 'RolesController'
                    ]);
            
                    /*Route::resource('categories', 'CategoriesController');
                    Route::resource('products', 'ProductsController')->names([
                        'index' => 'products.index',
                    ]);
                    Route::resource('roles', 'RolesController');*/
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
