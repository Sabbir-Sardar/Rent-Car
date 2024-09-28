@extends('layout.adminLayout')
@section('content')
    @include('adminComponents.cars.carList')
    @include('adminComponents.cars.carUpdate')
    @include('adminComponents.cars.carDelete')
    @include('adminComponents.cars.carCreate')
@endsection