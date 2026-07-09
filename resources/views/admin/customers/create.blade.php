@extends('admin.catalog.layouts.app')

@section('title', 'Add Customer')

@section('content')
    @include('admin.customers.form', ['customer' => null])
@endsection
