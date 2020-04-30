<?php

namespace App\Http\Middleware;

use App\ShoppingCart;

//use Illuminate\Support\Facades\View;

use Closure;

class SetShoppingCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //diccionario
        $sessionName = 'shopping_cart_id';
        $shopping_cart_id= \Session::get($sessionName);

        $shopping_cart = ShoppingCart::findOrCreateById($shopping_cart_id); //en dado caso que no exista sesion se crea
        //ver app/ShoppingCart

        \Session::put($sessionName, $shopping_cart->id); // se guarda la sesion en el navegador

        $request->shopping_cart = $shopping_cart; // pasar los datos al controllador
        return $next($request);
    }
}
