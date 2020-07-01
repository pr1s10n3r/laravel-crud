@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <create-product-component></create-product-component>
        </div>
        <div class="col-md-8">
            <product-list-component></product-list-component>
        </div>
    </div>
</div>
@endsection