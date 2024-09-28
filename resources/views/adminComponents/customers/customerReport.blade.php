<div class="modal animated zoomIn" id="report-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- Changed modal-md to modal-lg for larger size -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rental Report</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 p-1">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="reportData">
                                        <thead>
                                            <tr class="bg-light">
                                                <th>No</th>
                                                <th>Rental Id</th>
                                                <th>Customer Name</th>
                                                <th>Car Details [Brand]</th>
                                                <th>Rental Start & End Date</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody id="reportList">
                                            <!-- Table data goes here -->
                                        </tbody>
                                    </table>
                                </div>
                                <input type="text" class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                
            </div>
        </div>
    </div>
</div>

<style>
    .modal-lg {
        max-width: 60%; /* Increase modal width */
    }

    .modal-body {
        max-height: 80vh; /* Increased modal body height to fit more rows */
        overflow-y: auto; /* Enable scrolling if content overflows */
    }

    .table-responsive {
        max-height: 70vh; /* Adjust table height */
        overflow-y: auto;
    }
</style>


<script>
    async function fetchRentalReport(id) {
    showLoader();
    try {
        let response = await axios.get(`/customerRental/${id}`); // Update the route name
        let rentals = response.data;
        hideLoader();
        populateTable(rentals);
    } catch (error) {
        hideLoader();
       
        errorToast("An error occurred while fetching the rental .");
    }
}
    function populateTable(rentals) {
        let tableBody = document.getElementById("reportList");
        tableBody.innerHTML = ""; // Clear the table body

        rentals.forEach((rental, index) => {
            let row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${rental.id}</td>
                    <td>${rental.user.name}</td>
                    <td>${rental.car.brand}</td>
                    <td>${rental.start_date} - ${rental.end_date}</td>
                    <td>${rental.total_cost}</td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    }

    // Call the fetchRentalReport function when the modal is opened
   
</script>