<?php

namespace App\Providers;
use App\ShoppingCart;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
      View::composer('*', function($view){
        //diccionario
        $sessionName = 'shopping_cart_id';
        $shopping_cart_id = \Session::get($sessionName);

        $shopping_cart = ShoppingCart::findOrCreateById($shopping_cart_id); //en dado caso que no exista sesion se crea
        //ver app/ShoppingCart

        \Session::put($sessionName, $shopping_cart->id); // se guarda la sesion en el navegador

        $view->with('producstCount', $shopping_cart->productsCount()); // arg1 key arg2 valor (diccionario)
    });
    }
}
