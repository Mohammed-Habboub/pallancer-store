<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        $this->app->bind('cart.id', function(){
            $id = Cookie::get('cart_id');
            if(!$id) {
                $id = Str::uuid();
                Cookie::queue('cart_id', $id, 60 * 24 * 60);
            }
    
            return $id;

        });

        Validator::extend('filter', function ($attribute, $value, $param) {
            foreach ($param as $word) {

                if ( stripos($value, $word) !== false ) {
                    return false;
                }
                
            }
            return true;
        }, 'Invalide Word!');


        // with vendor:publish
        Paginator::defaultView('vendor.pagination.bootstrap-4');

        // without vender:publish
        //Paginator::useBootstrap();


    }
    

}
