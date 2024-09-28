<section id="search">
    <div class="container search-block p-5">
        <form class="row" id="search-form" method="POST" action="{{ route('searchCars') }}">
            @csrf
            <!-- Car Type Selection -->
            <div class="col-12 col-md-6 col-lg-3 mt-4 mt-lg-0">
                <label for="car-type" class="label-style text-capitalize form-label">Car Type</label>
                <div class="input-group date">
                    <select class="form-select form-control p-3" id="car_type" name="car_type" aria-label="Default select example">
                        <option value="" selected>Any Car Type</option> <!-- Allows search for all car types -->
                    </select>
                </div>
            </div>
            
            <!-- Car Brand Selection -->
            <div class="col-12 col-md-6 col-lg-3 mt-4 mt-lg-0">
                <label for="car-brand" class="label-style text-capitalize form-label">Car Brand</label>
                <div class="input-group date">
                    <select class="form-select form-control p-3" id="brand" name="brand" aria-label="Default select example">
                        <option value="" selected>Any Car Brand</option> <!-- Allows search for all brands -->
                    </select>
                </div>
            </div>
            
            <!-- Start Date -->
            <div class="col-12 col-md-6 col-lg-3 mt-4 mt-lg-0">
                <label for="pick-up-date" class="label-style text-capitalize form-label">Start Date</label>
                <div class="input-group date" id="datepicker1">
                    <input type="date" class="form-control p-3" id="pick-up-date" name="start_date" required />
                </div>
            </div>

            <!-- End Date -->
            <div class="col-12 col-md-6 col-lg-3 mt-4 mt-lg-0">
                <label for="return-date" class="label-style text-capitalize form-label">End Date</label>
                <div class="input-group date" id="datepicker2">
                    <input type="date" class="form-control p-3" id="return-date" name="end_date" required />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2 mt-4">
                <button class="btn btn-primary" id="find-car-btn" type="submit">Find Your Car</button>
            </div>
        </form>
    </div>
</section>

<!-- JavaScript to dynamically populate Car Types and Brands -->
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        try {
            const response = await fetch('/getCarTypesAndBrands');
            const data = await response.json();

            const carTypeSelect = document.getElementById('car_type');
            const carBrandSelect = document.getElementById('brand');

            // Populate car types
            data.car_types.forEach(type => {
                const option = document.createElement('option');
                option.value = type; // Use the actual type value
                option.textContent = type;
                carTypeSelect.appendChild(option);
            });

            // Populate car brands
            data.car_brands.forEach(brand => {
                const option = document.createElement('option');
                option.value = brand; // Use the actual brand value
                option.textContent = brand;
                carBrandSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching car types and brands:', error);
        }
    });
</script>
