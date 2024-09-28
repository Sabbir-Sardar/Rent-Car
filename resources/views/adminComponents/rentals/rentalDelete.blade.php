<div class="modal animated zoomIn" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteID"/>

            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn mx-2 bg-gradient-primary" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn  bg-gradient-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function itemDelete() {
        let id = document.getElementById('deleteID').value;

        // Close the delete modal
        document.getElementById('delete-modal-close').click();

        // Show loader while the request is being processed
        showLoader();

        try {
            // Make the DELETE request
            let res = await axios.delete(`/rentals/${id}`);

            hideLoader();

            // Check if the request was successful
            if (res.status === 200) {
                successToast("Customer deleted successfully");

                // Refresh the customer list after deletion
                await getList();
            } else {
                errorToast("Failed to delete the customer. Please try again.");
            }
        } catch (error) {
            hideLoader();
            console.error("Error during delete:", error);

            // Show an error toast in case of an exception
            errorToast("An error occurred while deleting the customer.");
        }
    }
</script>
