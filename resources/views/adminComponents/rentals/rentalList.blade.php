<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Rental List</h4>
                    </div>
                    
                </div>
                <hr class="bg-dark "/>
                <table class="table" id="tableData">
                    <thead>
                    <tr class="bg-light">
                        <th>No</th>
                        <th>Rental Id</th>
                        <th>Customer Name</th>
                        <th>Car Details[Brand]</th>
                        <th>Rental StartDate</th>
                        <th>Rental EndDate</th>
                        <th>Total Cost</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody id="tableList">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    getList();


    async function getList() {
        showLoader();
        let res=await axios.get("/rentalsList");
        hideLoader();

        let tableList=$("#tableList");
        let tableData=$("#tableData");

        tableData.DataTable().destroy();
        tableList.empty();

        res.data.forEach(function (item,index) {
            let row=`<tr>
                <td>${index + 1}</td>
                    <td>${item['id']}</td>
                    <td>${item.user['name']}</td>
                    <td>${item.car['name']} [${item.car['brand']}]</td>
                    <td>${item['start_date']}</td>
                    <td>${item['end_date']}</td>
                    <td>${item['total_cost']}৳</td>
                    <td>
                        <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success updateBtn">Update</button>
                        <button data-id="${item['id']}" class="btn btn-sm btn-outline-danger deleteBtn">Delete</button>
                    </td>
                 </tr>`
            tableList.append(row)
        })

        $('.editBtn').on('click', async function () {
            let id= $(this).data('id');
            await FillUpUpdateForm(id)
            $("#update-modal").modal('show');
        })

        $('.deleteBtn').on('click',function () {
            let id= $(this).data('id');
            $("#delete-modal").modal('show');
            $("#deleteID").val(id);
        })

        new DataTable('#tableData',{
            order:[[0,'desc']],
            lengthMenu:[5,10,15,20,30]
        });

       

    }
</script>