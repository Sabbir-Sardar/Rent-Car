@extends('layout.frontLayout')
@section('content')

@include('frontComponents.navbar')

@if (request()->routeIs('userProfile'))
    @include('frontComponents.profile')
    @elseif (request()->routeIs('userRental'))
    @include('frontComponents.userRental')
    @include('frontComponents.rentalDelete')
    @else
@include('frontComponents.hero')


@if(session('search') || request()->routeIs('view.all.rentals')|| request()->routeIs('searchCars')) 
        @include('frontComponents.search')
        @include('frontComponents.allCars')
        
    
    @else
        @include('frontComponents.search')
        @include('frontComponents.process')
        @include('frontComponents.rental')
        @include('frontComponents.service')
        @include('frontComponents.faq')
        @include('frontComponents.contact')
    @endif
    
    @if(auth()->check())
    <!-- If logged in, include the car booking modal -->
    @include('frontComponents.carBooking')
@else
    <!-- If not logged in, include the login twister modal -->
    
@endif
@endif
@include('frontComponents.footer')

@endsection