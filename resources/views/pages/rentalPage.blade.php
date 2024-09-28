@extends('layout.adminLayout')
@section('content')
    @include('adminComponents.rentals.rentalList')
    @include('adminComponents.rentals.rentalUpdate')
    @include('adminComponents.rentals.rentalDelete')
@endsection