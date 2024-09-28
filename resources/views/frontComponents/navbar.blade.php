<nav class="navbar navbar-expand-lg  navbar-light container-fluid py-3 position-fixed ">
    <div class="container">
        <a class="navbar-brand" href="{{('/')}}"><img src="{{asset('frontend/images/logo.png')}}" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav align-items-center justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active px-3" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#rental">Cars</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#">Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#services">Services</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#action">Contact</a>
                    </li>
                </ul>

                <div class="d-flex mt-5 mt-lg-0 ps-xl-5 align-items-center justify-content-center ">
                    @auth
                    <!-- Dropdown for authenticated users -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary nav-button mx-3 dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                            <iconify-icon icon="material-symbols:arrow-drop-down"></iconify-icon>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <!-- Profile Button -->
                            @if (Auth::user()->role =="admin")
                            <li class="nav-item">
                                <a class="nav-link px-3" href="{{('/admin')}}">Admin Page</a>
                            </li>
                            @else
                                <li class="nav-item">
                                <a class="nav-link px-3" href="{{ route('userProfile', ['id' => Auth::id()]) }}">Profile</a>
                            </li>
                            <!-- Running Order Button -->
                            <li class="nav-item"> 
                                <a class="nav-link px-3" href="{{ route('userRental', ['customerId' => Auth::id()]) }}">Rental History</a>
                            </li>
                            <!-- Previous Order Button -->
                           
                            @endif
                            
                            <!-- Logout Button (POST form to log out) -->
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link px-3">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- If no user is logged in, show the Sign in button -->
                    <button type="button" class="btn btn-outline-primary nav-button mx-3" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">Sign in</button>
                @endauth
                   
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="tabs-listing">
                                            <nav>
                                                <div class="nav nav-tabs d-flex justify-content-center border-0"
                                                    id="nav-tab" role="tablist">
                                                    <button
                                                        class="btn btn-outline-primary text-uppercase me-3 active"
                                                        id="nav-sign-in-tab" data-bs-toggle="tab"
                                                        data-bs-target="#nav-sign-in" type="button" role="tab"
                                                        aria-controls="nav-sign-in" aria-selected="true">Log
                                                        In</button>
                                                    <button class="btn btn-outline-primary text-uppercase"
                                                        id="nav-register-tab" data-bs-toggle="tab"
                                                        data-bs-target="#nav-register" type="button" role="tab"
                                                        aria-controls="nav-register" aria-selected="false">Sign
                                                        Up</button>
                                                </div>
                                            </nav>
                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane fade active show" id="nav-sign-in"
                                                    role="tabpanel" aria-labelledby="nav-sign-in-tab">
                                                    <form id="form1" class="form-group flex-wrap p-3 " method="POST" action="{{ route('login') }}">
                                                        @csrf
                                                        <div class="form-input col-lg-12 my-4">
                                                            <label for="exampleInputEmail1"
                                                                class="form-label fs-6 text-uppercase fw-bold text-black">Email
                                                                Address</label>
                                                            <input type="text" id="exampleInputEmail1" name="email"
                                                                placeholder="Email" class="form-control ps-3">
                                                        </div>
                                                        <div class="form-input col-lg-12 my-4">
                                                            <label for="inputPassword1"
                                                                class="form-label  fs-6 text-uppercase fw-bold text-black">Password</label>
                                                            <input type="password" id="inputPassword1" name="password"
                                                                placeholder="Password" class="form-control ps-3"
                                                                aria-describedby="passwordHelpBlock">
                                                            

                                                        </div>
                                                        
                                                        <div class="d-grid my-3">
                                                           
                                                                <button
                                                                class="btn btn-primary btn-lg btn-dark text-uppercase btn-rounded-none fs-6">Log
                                                                In</button>
                                                           
                                                            
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="nav-register" role="tabpanel"
                                                    aria-labelledby="nav-register-tab">
                                                    <form id="form2" class="form-group flex-wrap p-3 " 
                                                         method="POST" action="{{ route('register') }}">
                                                          @csrf
                                                        <div class="form-input col-lg-12 my-4">
                                                            <label for="exampleInputEmail2"
                                                                class="form-label fs-6 text-uppercase fw-bold text-black">Name
                                                            </label>
                                                            <input type="text" id="exampleInputEmail2" name="name"
                                                                placeholder="Name" class="form-control ps-3">
                                                        </div>

                                                        <div class="form-input col-lg-12 my-4">
                                                            <label for="exampleInputEmail2"
                                                                class="form-label fs-6 text-uppercase fw-bold text-black">Email
                                                                Address</label>
                                                            <input type="email" id="exampleInputEmail2" name="email"
                                                                placeholder="Email" class="form-control ps-3">
                                                        </div>

                                                        <div class="form-input col-lg-12 my-4">
                                                            <label for="exampleInputEmail2"
                                                                class="form-label fs-6 text-uppercase fw-bold text-black">Phone
                                                                Number</label>
                                                            <input type="number" id="exampleInputEmail2" name="phone_number"
                                                                placeholder="Phone Number" class="form-control ps-3">
                                                        </div>

                                                        <div class="form-input col-lg-12 my-4">
                                                            <label for="exampleInputEmail2"
                                                                class="form-label fs-6 text-uppercase fw-bold text-black">Address
                                                                </label>
                                                            <input type="text" id="exampleInputEmail2" name="address"
                                                                placeholder="Address" class="form-control ps-3">
                                                        </div>

                                                        <div class="form-input col-lg-12 my-4">
                                                            <label for="inputPassword2"
                                                                class="form-label  fs-6 text-uppercase fw-bold text-black">New Password</label>
                                                            <input type="password" id="inputPassword2" name="password"
                                                                placeholder="New Password" class="form-control ps-3"
                                                                aria-describedby="passwordHelpBlock">
                                                        </div>

                                                        <div class="d-grid my-3">
                                                            <button
                                                                class="btn btn-primary btn-lg btn-dark text-uppercase btn-rounded-none fs-6">Sign
                                                                Up</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>