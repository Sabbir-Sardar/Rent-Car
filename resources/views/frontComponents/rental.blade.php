<section id="rental" class="position-relative">
    <div class="container my-5 py-5">
        <h2 class=" text-center my-5">cars for <span class="text-primary"> rental </span> </h2>

        <div class="swiper-button-next rental-swiper-next  rental-arrow position-absolute"></div>
        <div class="swiper-button-prev rental-swiper-prev rental-arrow position-absolute"></div>

        <div class="swiper rental-swiper mb-5">
            <div class="swiper-wrapper">
                @foreach($availableCars as $car)
                <div class="swiper-slide">
                    <div class="card">
                        <a href="{{ route('car.show', $car->id) }}"><img src="{{ asset($car->image) }}" class="card-img-top" alt="{{ $car->name }}"></a>
                        <div class="card-body p-4">
                            <a href="{{ route('car.show', $car->id) }}">
                                <h4 class="card-title">{{ $car->name }}</h4>
                            </a>
                            <div class="card-text ">
                                <ul class="d-flex list-unstyled">
                                    <li class="rental-list"><strong>Brand: </strong>
                                        {{ $car->brand }}
                                    </li>
                                    <li class="rental-list"> <img src="{{asset('frontend/images/dot.png')}}" class="px-3" alt="image">
                                    </li>
                                    <li class="rental-list"><strong>Type: </strong>{{ $car->car_type }}</li>
                                </ul>
                                <ul class="d-flex list-unstyled">
                                    
                                    <li class="rental-list"><strong>Manufacture Year: </strong>{{ $car->year }} </li>
                                   
                                </ul>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h3 class="pt-2">৳{{$car->daily_rent_price}}  <span class="rental-price">/day</span></h3>
                                <button class="btn btn-primary btn-sm" onclick="openBookingModal({{ $car->id }}, '{{ $car->name }}', {{ $car->daily_rent_price }})">
                                    Rent Now
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
    <!-- hero section start  -->         
    @endforeach
 
            </div>
            <div class="d-flex justify-content-center my-4">
                <a href="{{ route('view.all.rentals') }}" class="btn btn-outline-success">View All</a>
            </div>
        </div>

    </div>
</section>
<script>
       function openBookingModal(carId, carName, rentPrice) {
        @auth
    // Populate the modal fields with car details
    document.getElementById('car_id').value = carId;
    document.getElementById('car_name').value = carName;
    document.getElementById('rent_price').value = '৳' + rentPrice + '/day';

    // Show the modal
    var bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
    bookingModal.show();
    @else
        // Display a SweetAlert asking the user to log in
        Swal.fire({
            title: 'Please log in to rent a car',
            text: 'You need to be logged in to rent a car. Please log in or create an account.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Log in',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect the user to t
                $('#exampleModal').modal('show');
            }
        });
    @endauth
}
</script>
