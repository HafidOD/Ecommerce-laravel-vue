<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ShoppingCart;
use App\Http\Resources\ProductsCollection;

class ProductsController extends Controller
{
    //middleware para validar autenticacion
    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'show']]); //si no se pasa lista de ecepsiones se aplica a todas las vistas
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // compartir el mismo datos en todas las paginas ver app/providers/appserviceprovider
        // session y carrito de compra

        $products = Product::paginate(15); //paginacion, resive como parametro la cantidad de elementos en cada pag

        // las cabeceras definen si el cliente espera application/json
        if($request->wantsJson()){
            //return $products->toJson(); // responde con JSON
            return new ProductsCollection($products); //nueva instancia de productscollections
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
        $options = [
            'title'=> $request->title,
            'description'=> $request->description,
            'price'=> $request->price
        ];

        if (Product::create($options)){
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

        return view('products.show', ["product" => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id); //se se busca el producto por el id 
        return view("products.edit", ["product" => $product]); // el segundo parametro indica que se enviara la info a la vista con el nombre (arg1), valor (arg2)
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
        $product->price = $request->price;

        if($product->save()){
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
