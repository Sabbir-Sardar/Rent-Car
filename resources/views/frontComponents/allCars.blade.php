<section id="rental" class="position-relative">
    <div class="container my-5 py-4">

    </div>
    <div class="container my-5 py-5">
        <!-- Navigation bar with title and filter option -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Cars for <span class="text-primary">Rental</span></h2>
            <div>
                <select class="form-select" id="filter" aria-label="Filter Cars">
                    <option selected>Filter by...</option>
                    <option value="price_low_high">Price: Low to High</option>
                    <option value="price_high_low">Price: High to Low</option>
                    <option value="latest">Latest Cars</option>
                </select>
            </div>
        </div>

        <!-- Car grid: 4 cards per row -->
        @if($availableCars->isEmpty())
            <p>No cars are available for the selected criteria.</p>
        @else
        <div class="row" id="car-list">
            @foreach($availableCars as $car)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <a href="{{ route('car.show', $car->id) }}">
                        <img src="{{ asset($car->image) }}" class="card-img-top" alt="{{ $car->name }}">
                    </a>
                    <div class="card-body p-4">
                        <a href="{{ route('car.show', $car->id) }}">
                            <h4 class="card-title">{{ $car->name }}</h4>
                        </a>
                        <div class="card-text">
                            <ul class="list-unstyled">
                                <li><strong>Brand:</strong> {{ $car->brand }}<strong> Type:</strong> {{ $car->car_type }}</li>
                                
                                <li><strong>Year:</strong> {{ $car->year }}</li>
                            </ul>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                           <h4 id="rent-price"> 
                            ৳{{ $car->daily_rent_price }}<span class="rental-price">/day</span>
                           </h4>
                           </div>
                           <button class="btn btn-primary btn-sm" onclick="openBookingModal({{ $car->id }}, '{{ $car->name }}', {{ $car->daily_rent_price }})">
                            Rent Now
                        </button>
                            <hr>
                    </div>
                  
                </div>
            </div>
            @endforeach
        </div>
        @endif
        <!-- Pagination (assumes Laravel's built-in pagination) -->
        
    </div>
</section>

<script>
    
    document.getElementById('filter').addEventListener('change', async function() {
        let filter = this.value;
        let carList = document.getElementById('car-list');

        // Send async request to the backend to filter the cars
        try {
            let response = await fetch(`/filter-cars?filter=${filter}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            let cars = await response.json();

            // Clear current car list
            carList.innerHTML = '';

            // Iterate through the filtered cars and append them
            cars.forEach(car => {
                carList.innerHTML += `
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <a href="/car/${car.id}">
                                <img src="${car.image}" class="card-img-top" alt="${car.name}">
                            </a>
                            <div class="card-body p-4">
                                <a href="/car/${car.id}">
                                    <h4 class="card-title">${car.name}</h4>
                                </a>
                                <div class="card-text">
                                    <ul class="list-unstyled">
                                        <li><strong>Brand:</strong> ${car.brand}<strong> Type:</strong> ${car.car_type}</li>
                                        <li><strong>Year:</strong> ${car.year}</li>
                                    </ul>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h4 id="rent-price"> ৳${car.daily_rent_price}<span class="rental-price">/day</span></h4>
                                </div>
                                <button class="btn btn-primary btn-sm" onclick="openBookingModal(${car.id}, '${car.name}', ${car.daily_rent_price})">Rent Now</button>
                               
                                <hr>
                            </div>
                        </div>
                    </div>`;
            });
        } catch (error) {
            console.error('Error fetching filtered cars:', error);
        }
    });
  

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