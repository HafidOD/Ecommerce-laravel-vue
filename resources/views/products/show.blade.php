@extends('layouts.app')

@section('content')
<div class="row justify-content-sm-center">
  <div class="col-xs-12 col-sm-10 col-md-7 col-lg-6">
    <div class="card">
      <header class="padding text-center bg-primary">
      </header>
      <div class="card-body padding">
        <div class="">
          <img class="card-img-top imgshow mx-auto" src="/images/{{$product->image_url }}" alt="{{$product->image_url }}">
        </div>

        <h2 class="card-title">{{$product->title}}</h2>
        <div class="padding">
          <h3>Precio:</h3>
          <h4 class="card-subtitle">${{$product->price}} MXN</h4>
        </div>

        <div class="padding">
          <h3>Descripcion:</h3>
          <p class="card-text">{{ $product->description}}</p>
        </div>

				<div class="padding">
				<p>Vendido por: {{ $username }} </p>
				</div>

        <div class="card-actions">
          <add-product-btn :product='{!! json_encode($product) !!}'></add-product-btn>
          @include('products.delete')
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
