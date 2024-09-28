<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Car Name *</label>
                                <input type="text" class="form-control" id="carNameUpdate">
                                
                                <label class="form-label mt-3">Rental Start Date *</label>
                                <input type="date" class="form-control" id="start_date">

                                <label class="form-label mt-3">Rental End Date *</label>
                                <input type="date" class="form-control" id="end_date">

                                <input type="text" class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>
        </div>
    </div>
</div>


<script>



    async function FillUpUpdateForm(id){
        document.getElementById('updateID').value=id;
        showLoader();
        let res = await axios.get(`/get-booking-details/${id}`);
        hideLoader();
        document.getElementById('carNameUpdate').value=res.data.car.name;
        document.getElementById('start_date').value=res.data['start_date'];
        document.getElementById('end_date').value=res.data['end_date'];
        
    }


    async function Update() {
    let updateID = document.getElementById('updateID').value;
    let startDate = document.getElementById('start_date').value;
    let endDate = document.getElementById('end_date').value;

    if (startDate.length === 0) {
        errorToast("Rental Start Date Required !");
    } else if (endDate.length === 0) {
        errorToast("Rental End Date Required !");
    } else {
        document.getElementById('update-modal-close').click();

        showLoader();

        try {
            let res = await axios.put(`/update-booking/${updateID}`, {
                start_date: startDate,
                end_date: endDate,
            });

            hideLoader();

            if (res.status === 200) {
                successToast('Booking updated successfully');

                document.getElementById("update-form").reset();

                await getList();
            } else {
                errorToast("Request failed! Please try again.");
            }
        } catch (error) {
            hideLoader();
            console.error("Error during the update:", error);
            errorToast("An error occurred while updating the booking.");
        }
    }
}
</script>
