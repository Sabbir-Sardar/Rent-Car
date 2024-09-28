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
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate">

                                <label class="form-label mt-3">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmailUpdate">

                                <label class="form-label mt-3">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobileUpdate">

                                <label class="form-label mt-3">Customer Address *</label>
                                <input type="text" class="form-control" id="customerAddressUpdate">


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
        let res = await axios.get(`/customers/${id}`);
        hideLoader();
        document.getElementById('customerNameUpdate').value=res.data['name'];
        document.getElementById('customerEmailUpdate').value=res.data['email'];
        document.getElementById('customerMobileUpdate').value=res.data['phone_number'];
        document.getElementById('customerAddressUpdate').value=res.data['address'];
    }


    async function Update() {

        let customerName = document.getElementById('customerNameUpdate').value;
        let customerEmail = document.getElementById('customerEmailUpdate').value;
        let customerMobile = document.getElementById('customerMobileUpdate').value;
        let customerAddress = document.getElementById('customerAddressUpdate').value;
        let updateID = document.getElementById('updateID').value;


        if (customerName.length === 0) {
            errorToast("Customer Name Required !")
        }
        else if(customerEmail.length===0){
            errorToast("Customer Email Required !")
        }
        else if(customerMobile.length===0){
            errorToast("Customer Mobile Required !")
        }
        else if(customerAddress.length===0){
            errorToast("Customer Address Required !")
        }
        else {

            document.getElementById('update-modal-close').click();

            showLoader();

            try {
            // Make the PUT request using updateID
            let res = await axios.put(`/customers/${updateID}`, {
                name: customerName,
                email: customerEmail,
                phone_number: customerMobile, 
                address: customerAddress
            });

            hideLoader();

            // Check for successful status code (200) and handle response
            if (res.status === 200) {
                successToast('Customer updated successfully');

                // Clear the form after success
                document.getElementById("update-form").reset();

                // Refresh the list of customers
                await getList();
            } else {
                errorToast("Request failed! Please try again.");
            }
        } catch (error) {
            hideLoader();
            console.error("Error during the update:", error);
            errorToast("An error occurred while updating the customer.");
        }
        }
    }

</script>
