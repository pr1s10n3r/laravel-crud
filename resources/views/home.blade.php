@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nuestros Productos</h2>
    @foreach($products as $product)
    <div class="card mb-3">
        <div class="row no-gutters align-items-center">
            <div class="col-md-4">
                <img src={{ asset("images/$product->image") }} class="card-img product-image">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">
                        <?php
                        $fmt = numfmt_create('es_CO', NumberFormatter::CURRENCY);
                        echo numfmt_format_currency($fmt, $product->price, 'COP');
                        ?>
                    </p>
                    <p class="card-text">{{ $product->description }}</p>
                    <button type="button" class="btn btn-primary">Comprar</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection