<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Car</h5>
            </div>
            <div class="modal-body">
                <form id="save-form" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row">
                            <div class="col-6 p-1">
                                <label class="form-label">Car Name</label>
                                <input type="text" class="form-control" id="carName">
                            </div>
                            <div class="col-6 p-1">
                                <label class="form-label">Brand</label>
                                <input type="text" class="form-control" id="carBrand">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 p-1">
                                <label class="form-label mt-2">Model</label>
                                <input type="text" class="form-control" id="carModel">
                            </div>
                            <div class="col-6 p-1">
                                <label class="form-label mt-2">Year of Manufacture</label>
                                <input type="number" class="form-control" id="carYear">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 p-1">
                                <label class="form-label mt-2">Car Type</label>
                                <select class="form-control form-select" id="carType">
                                    <option value="">Select Car Type</option>
                                    <option value="SUV">SUV</option>
                                    <option value="Sedan">Sedan</option>
                                    <option value="Hatchback">Hatchback</option>
                                </select>
                            </div>
                            <div class="col-6 p-1">
                                <label class="form-label mt-2">Daily Rent Price</label>
                                <input type="number" class="form-control" id="carRentPrice">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 p-1">
                                <label class="form-label mt-2">Availability</label>
                                <select class="form-control form-select" id="carAvailability">
                                    <option value="">Select Availability</option>
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>
                            <div class="col-6 p-1">
                                <br/>
                                <img class="w-15" id="newImg" src="{{ asset('images/default.jpg') }}"/>
                                <br/>

                                <label class="form-label mt-2">Car Image</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="carImg">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
    async function Save() {
        let carName = document.getElementById('carName').value;
        let carBrand = document.getElementById('carBrand').value;
        let carModel = document.getElementById('carModel').value;
        let carYear = document.getElementById('carYear').value;
        let carType = document.getElementById('carType').value;
        let carRentPrice = document.getElementById('carRentPrice').value;
        let carAvailability = document.getElementById('carAvailability').value;
        let carImg = document.getElementById('carImg').files[0];

        // Validation checks
        if (carName.length === 0) {
            errorToast("Car Name is Required!");
        } else if (carBrand.length === 0) {
            errorToast("Car Brand is Required!");
        } else if (carModel.length === 0) {
            errorToast("Car Model is Required!");
        } else if (carYear.length === 0) {
            errorToast("Car Year of Manufacture is Required!");
        } else if (carType.length === 0) {
            errorToast("Car Type is Required!");
        } else if (carRentPrice.length === 0) {
            errorToast("Daily Rent Price is Required!");
        } else if (carAvailability.length === 0) {
            errorToast("Availability Status is Required!");
        } else if (!carImg) {
            errorToast("Car Image is Required!");
        } else {
            document.getElementById('modal-close').click();

            // Create FormData object for file and form data
            let formData = new FormData();
            formData.append('image', carImg);
            formData.append('name', carName);
            formData.append('brand', carBrand);
            formData.append('model', carModel);
            formData.append('year', carYear);
            formData.append('car_type', carType);
            formData.append('daily_rent_price', carRentPrice);
            formData.append('availability', carAvailability);

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            try {
                showLoader();
                let res = await axios.post("/carCreate", formData, config);
                hideLoader();

                if (res.status === 201) {
                    successToast('Car added successfully');
                    document.getElementById("save-form").reset();
                    await getList(); // Assuming you have a function to reload the car list
                } else {
                    errorToast("Car creation failed!");
                }

            } catch (error) {
                hideLoader();
                errorToast("An error occurred while saving the car.");
            }
        }
    }
</script>
