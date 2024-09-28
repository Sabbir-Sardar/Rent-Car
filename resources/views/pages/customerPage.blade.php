@extends('layout.adminLayout')
@section('content')
    @include('adminComponents.customers.customerList')
    @include('adminComponents.customers.customerUpdate')
    @include('adminComponents.customers.customerDelete')
    @include('adminComponents.customers.customerCreate')
    @include('adminComponents.customers.customerReport')
@endsection