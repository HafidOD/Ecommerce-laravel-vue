<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductsCollection;

class ShoppingCartController extends Controller
{
    public function __construct(){
        $this->middleware('shopping_cart');
    }

    public function show(Request $request){
        return view('shopping_cart.show', ['shopping_cart' =>$request->shopping_cart]);
    }

    public function products(Request $request){
        return new ProductsCollection($request->shopping_cart->products()->get());
      }
    
    
}
