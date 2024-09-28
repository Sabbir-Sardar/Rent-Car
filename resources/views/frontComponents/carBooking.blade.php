<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tabs-listing">
                    <nav>
                        <div class="nav nav-tabs d-flex justify-content-center border-0" id="nav-tab" role="tablist">
                            <h2 class="mb-0"><span class="text-primary">Booking Now</span></h2>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-sign-in" role="tabpanel" aria-labelledby="nav-sign-in-tab">
                            <hr>
                            <form id="bookingForm" method="POST" action="{{ route('book.car') }}">
                                @csrf
                                <input type="hidden" id="car_id" name="car_id">
                                <div class="form-group mb-3">
                                    <label for="car_name" class="form-label">Car Name:</label>
                                    <input type="text" id="car_name" class="form-control" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="rent_price" class="form-label">Rental Amount/Day:</label>
                                    <input type="text" id="rent_price" class="form-control" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="rental_start_date" class="form-label">Rental Start Date</label>
                                    <input type="date" id="rental_start_date" name="rental_start_date" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="rental_end_date" class="form-label">Rental End Date</label>
                                    <input type="date" id="rental_end_date" name="rental_end_date" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100" id="bookNowButton">Book Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$('#bookingForm').submit(async function(e) {
    e.preventDefault();

    // Collect form data
    var formData = {
        car_id: $('#car_id').val(),
        rental_start_date: $('#rental_start_date').val(),
        rental_end_date: $('#rental_end_date').val(),
        _token: "{{ csrf_token() }}" // Laravel CSRF token
    };

    try {
        const response = await $.ajax({
            url: "{{ route('book.car') }}",
            method: 'POST',
            data: formData,
            async: true
        });

        // Close the modal first
        $('#bookingModal').modal('hide');

        // Wait for the modal to fully close before showing SweetAlert
        $('#bookingModal').on('hidden.bs.modal', function () {
            if (response.success) {
                // SweetAlert for success
                Swal.fire({
                    icon: 'success',
                    title: 'Booking Successful',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000, // Automatically close the alert after 2 seconds
                }).then(() => {
                    // Reload the page to prevent the JSON response from being displayed
                    location.reload();
                });
            } else {
                // SweetAlert for error
                Swal.fire({
                    icon: 'error',
                    title: 'Booking Failed',
                    text: response.message,
                    showConfirmButton: true
                });
            }
        });
        
    } catch (error) {
        // Handle any errors that occur during the AJAX request
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Please try again later.',
            showConfirmButton: true
        });
    }
});


</script>
