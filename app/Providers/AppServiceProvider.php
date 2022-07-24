<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
