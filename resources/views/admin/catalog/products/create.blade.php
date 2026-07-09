@extends('admin.catalog.layouts.app')

@section('title', 'Add Product')

@section('content')
    @include('admin.catalog.products.form', ['product' => null])
@endsection
