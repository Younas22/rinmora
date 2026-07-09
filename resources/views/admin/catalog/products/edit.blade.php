@extends('admin.catalog.layouts.app')

@section('title', 'Edit Product')

@section('content')
    @include('admin.catalog.products.form', ['product' => $product])
@endsection
