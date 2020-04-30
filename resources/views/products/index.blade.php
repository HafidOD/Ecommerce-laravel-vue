@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <prodcuts-component />
    </div>

    <!-- para paginacion -->
    <div class="actions text-center">
        {{$products->links()}}
    </div>
</div>
@endsection
