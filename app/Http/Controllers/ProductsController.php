<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;

use App\Http\Resources\ProductsCollection;

class ProductsController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
		$products = User::where('id',auth()->id())->with('products')->paginate(10);
		// $products = Product::where('user_id', auth()->id())->paginate(10);
		// return $products;
    // las cabeceras definen si el cliente espera application/json
    if ($request->wantsJson()) {
      //return $products->toJson(); // responde con JSON
      return new ProductsCollection($products);
    }
    return view('products.index', ['products' => $products]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $product = new Product;
    return view('products.create', ["product" => $product]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if ($request->hasFile('image_url')) {
      $file = $request->file('image_url');
      $name = time() . $file->getClientOriginalName();
      $file->move(public_path() . '/images/', $name);
      $options = [
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price * 100,
				'image_url' => $name,
				'user_id' => auth()->id()
      ];
    }

    if (!$request->hasFile('image_url')) {
      $options = [
        'title' => $request->title,
        'description' => $request->description,
				'price' => $request->price * 100,
				'image_url' => 'img-default.jpg',
				'user_id' => auth()->id()
      ];
		}
    if (Product::create($options)) {
      return redirect('/productos');
    } else {
      return view('products.create');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $product = Product::find($id);
		$product->price = $product->price / 100;
		$user = auth()->user()->name;
		// var_dump($user);
    return view('products.show', ["product" => $product, "username" => $user]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $product = Product::find($id);
		$product->price = $product->price / 100;
		// return $product;
    return view("products.edit", ["product" => $product]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $product = Product::find($id);

		$product->title = $request->title;
    $product->description = $request->description;
    $product->price = $request->price * 100;
    if ($request->hasFile('image_url')) {
      $file = $request->file('image_url');
      $name = time() . $file->getClientOriginalName();
      $file->move(public_path() . '/images/', $name);
      $product->image_url = $name;
    }

    if (!$request->hasFile('image_url')) {
      $product->image_url = 'img-default.jpg';
    }

    if ($product->save()) {
      return redirect('/productos');
    } else {
      return view("products.edit", ["product" => $product]);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    Product::destroy($id);
    return redirect('/productos');
  }
}
