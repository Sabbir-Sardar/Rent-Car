<div class="container-fluid">
    <div class="row">

        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
            <div class="card card-plain h-100 bg-white">
                <div class="p-3">
                    <div class="row">
                        <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                            <div>
                                <h5 class="mb-0 text-capitalize font-weight-bold">
                                    <span id="car"></span>
                                </h5>
                                <p class="mb-0 text-sm">Total Car</p>
                            </div>
                        </div>
                        <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow float-end border-radius-md">
                                <img class="w-100 " src="{{asset('images/icon.svg')}}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
            <div class="card card-plain h-100 bg-white">
                <div class="p-3">
                    <div class="row">
                        <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                            <div>
                                <h5 class="mb-0 text-capitalize font-weight-bold">
                                    <span id="availableCar"></span>
                                </h5>
                                <p class="mb-0 text-sm">Total Available Car</p>
                            </div>
                        </div>
                        <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow float-end border-radius-md">
                                <img class="w-100 " src="{{asset('images/icon.svg')}}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
            <div class="card card-plain h-100 bg-white">
                <div class="p-3">
                    <div class="row">
                        <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                            <div>
                                <h5 class="mb-0 text-capitalize font-weight-bold">
                                    <span id="user"></span>
                                </h5>
                                <p class="mb-0 text-sm">Total User</p>
                            </div>
                        </div>
                        <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow float-end border-radius-md">
                                <img class="w-100 " src="{{asset('images/icon.svg')}}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
            <div class="card card-plain h-100  bg-white">
                <div class="p-3">
                    <div class="row">
                        <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                            <div>
                                <h5 class="mb-0 text-capitalize font-weight-bold">
                                    <span id="rental"></span>
                                </h5>
                                <p class="mb-0 text-sm">Total Rental</p>
                            </div>
                        </div>
                        <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow float-end border-radius-md">
                                <img class="w-100 " src="{{asset('images/icon.svg')}}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
            <div class="card card-plain h-100 bg-white">
                <div class="p-3">
                    <div class="row">
                        <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                            <div>
                                <h5 class="mb-0 text-capitalize font-weight-bold">
                                    ৳ <span id="total_earn"></span>
                                </h5>
                                <p class="mb-0 text-sm">Total Earning</p>
                            </div>
                        </div>
                        <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow float-end border-radius-md">
                                <img class="w-100 " src="{{asset('images/icon.svg')}}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


      


      

    </div>
</div>




<script>
    getList();
    async function getList() {
        showLoader();
        let res=await axios.get("/summary");

        document.getElementById('car').innerText=res.data['car']
        document.getElementById('availableCar').innerText=res.data['availableCar']
        document.getElementById('user').innerText=res.data['user']
        document.getElementById('rental').innerText=res.data['rental']
        document.getElementById('total_earn').innerText=res.data['total_earn']
       


        hideLoader();
    }

</script>

