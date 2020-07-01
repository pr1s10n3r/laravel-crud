@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-4 cmb-10">
            <create-product-component></create-product-component>
        </div>
        <div class="col-sm-12 col-md-8">
            <product-list-component></product-list-component>
        </div>
    </div>

    <edit-product-component></edit-product-component>
</div>
@endsection