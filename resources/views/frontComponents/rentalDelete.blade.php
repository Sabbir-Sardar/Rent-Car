<div class="modal animated zoomIn" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class="mt-3 text-warning">Cancel!</h3>
                <p class="mb-3">Confirm Cancellation of Your Rental?</p>
                <input type="hidden" id="deleteID" />
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn mx-2 bg-gradient-primary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" id="rentalID" />
                    </form>
                    <button onclick="confirmDelete()" type="button" id="confirmDelete" class="btn bg-gradient-danger">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to set the delete ID and show the modal
    $('.deleteBtn').on('click', function () {
        let id = $(this).data('id');
        $("#delete-modal").modal('show');
        $("#rentalID").val(id); // Set the rental ID in the hidden input
    });

    // Function to submit the form when the confirm button is clicked
    function confirmDelete() {
        let rentalId = document.getElementById('rentalID').value;
        document.getElementById('deleteForm').action = `/deleteRental/${rentalId}`; // Set the action to the delete route
        document.getElementById('deleteForm').submit(); // Submit the form
    }
</script>
