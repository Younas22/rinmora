@extends('admin.catalog.layouts.app')

@section('title', 'Edit Customer')

@section('content')
    @include('admin.customers.form', ['customer' => $customer])
@endsection
