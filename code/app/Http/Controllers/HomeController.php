<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;

use App\Http\Resources\ProductsCollection;
use App\User;

class HomeController extends Controller
{
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index(Request $request)
	{
		// $products = Product::paginate(10); //paginacion
		// las cabeceras definen si el cliente espera application/json
		$products = User::with('products')->paginate(10);

		if ($request->wantsJson()) {
			return new ProductsCollection($products);
		}
		return view('products.index', ['products' => $products]);
	}
}
