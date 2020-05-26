@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <!-- <products-component /> -->
				<user-products-component />
    </div>

    <!-- para paginacion -->
    <div class="actions text-center">
        {{$products->links()}}
    </div>
</div>
@endsection
