<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Car</h5>
            </div>
            <div class="modal-body">
                <form id="update-form" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row">
                            <!-- First Row: Car Name and Brand -->
                            <div class="col-md-6 p-1">
                                <label class="form-label">Car Name</label>
                                <input type="text" class="form-control" id="carNameUpdate">
                            </div>
                            <div class="col-md-6 p-1">
                                <label class="form-label">Brand</label>
                                <input type="text" class="form-control" id="carBrandUpdate">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Second Row: Model and Year -->
                            <div class="col-md-6 p-1">
                                <label class="form-label">Model</label>
                                <input type="text" class="form-control" id="carModelUpdate">
                            </div>
                            <div class="col-md-6 p-1">
                                <label class="form-label">Year of Manufacture</label>
                                <input type="number" class="form-control" id="carYearUpdate">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Third Row: Car Type and Daily Rent Price -->
                            <div class="col-md-6 p-1">
                                <label class="form-label">Car Type</label>
                                <select class="form-control form-select" id="carTypeUpdate">
                                    <option value="">Select Car Type</option>
                                    <option value="SUV">SUV</option>
                                    <option value="Sedan">Sedan</option>
                                    <option value="Hatchback">Hatchback</option>
                                </select>
                            </div>
                            <div class="col-md-6 p-1">
                                <label class="form-label">Daily Rent Price</label>
                                <input type="number" class="form-control" id="carRentPriceUpdate">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Fourth Row: Availability and Image -->
                            
                            <div class="col-md-6 p-1">
                                <label class="form-label">Car Image</label>
                                <input oninput="oldCarImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="carImgUpdate">
                            </div>
                            <div class="col-md-6 p-1">
                                <label class="form-label">Availability</label>
                                <select class="form-control form-select" id="carAvailabilityUpdate">
                                    <option value="">Select Availability</option>
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>
                        </div>
                        

                        <br />
                        <img class="w-15" id="oldCarImg" src="{{ asset('images/default.jpg') }}" alt="Current Car Image" />
                        <br />


                        <!-- Hidden fields for storing update ID and file path -->
                        <input type="hidden" id="updateID">
                        <input type="hidden" id="carFilePath">
                        
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="updatecar()" id="update-btn" class="btn bg-gradient-success">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to fill the update modal with car data
    async function FillUpUpdateForm(id) {
        showLoader();
        
        let res = await axios.get(`/cars/${id}`);  // Fetch car details by ID
        hideLoader();

        // Populate the fields with the retrieved car data
        document.getElementById('updateID').value = res.data.id;
        document.getElementById('carNameUpdate').value = res.data.name;
        document.getElementById('carBrandUpdate').value = res.data.brand;
        document.getElementById('carModelUpdate').value = res.data.model;
        document.getElementById('carYearUpdate').value = res.data.year;
        document.getElementById('carTypeUpdate').value = res.data.car_type;
        document.getElementById('carRentPriceUpdate').value = res.data.daily_rent_price;
        document.getElementById('carAvailabilityUpdate').value = res.data.availability;

        // Set old image source
        const imagePath = res.data.image ? `/${res.data.image}` : "{{ asset('images/default.jpg') }}";
        document.getElementById('oldCarImg').src = imagePath;
    }
    async function updatecar() {
    const carName = document.getElementById('carNameUpdate').value;
    const carBrand = document.getElementById('carBrandUpdate').value;
    const carModel = document.getElementById('carModelUpdate').value;
    const carYear = document.getElementById('carYearUpdate').value;
    const carType = document.getElementById('carTypeUpdate').value;
    const carRentPrice = document.getElementById('carRentPriceUpdate').value;
    const carAvailability = document.getElementById('carAvailabilityUpdate').value;
    const updateID = document.getElementById('updateID').value;
    const carImgUpdate = document.getElementById('carImgUpdate').files[0]; // Get the file input

    // Validation
    if (carName.length === 0) {
        return errorToast("Car Name Required!");
    }
    if (carBrand.length === 0) {
        return errorToast("Brand Name Required!");
    }
    if (carModel.length === 0) {
        return errorToast("Model Required!");
    }
    if (carYear.length === 0) {
        return errorToast("Year Required!");
    }
    if (carType.length === 0) {
        return errorToast("Type Required!");
    }
    if (carRentPrice.length === 0) {
        return errorToast("Rent Price Required!");
    }
    if (carAvailability.length === 0) {
        return errorToast("Availability Required!");
    }

    // Close modal and show loader
    document.getElementById('update-modal-close').click();
    showLoader();

    const formData = new FormData();
    formData.append('_method', 'PUT'); // Add this line to specify the request method
    formData.append('name', carName);
    formData.append('brand', carBrand);
    formData.append('model', carModel);
    formData.append('year', carYear);
    formData.append('car_type', carType);
    formData.append('daily_rent_price', carRentPrice);
    formData.append('availability', carAvailability);

    // Append file only if it's selected
    if (carImgUpdate) {
        formData.append('image', carImgUpdate);
    }

    try {
        // Make the PUT request using updateID
        const res = await axios.post(`/cars/${updateID}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        hideLoader();
        if (res.status === 200) {
            successToast('Car updated successfully');

            // Clear the form after success
            document.getElementById("update-form").reset();

            // Refresh the list of cars
            await getList();
        } else {
            errorToast("Request failed! Please try again.");
        }
    } catch (error) {
        hideLoader();
        console.error("Error during the update:", error);
        errorToast("An error occurred while updating the car.");
    }
}

</script>
