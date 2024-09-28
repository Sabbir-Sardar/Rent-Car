<section id="hero" class="position-relative overflow-hidden">
  <div class="pattern-overlay pattern-right position-absolute">
      <img src="{{ asset('frontend/images/hero-pattern-right.png') }}" alt="pattern">
  </div>
  <div class="pattern-overlay pattern-left position-absolute">
      <img src="{{ asset('frontend/images/hero-pattern-left.png') }}" alt="pattern">
  </div>
  <div class="hero-content container text-center">
      <div class="row justify-content-center"> <!-- Centering the row -->
          <div class="col-lg-8"> <!-- Adjusted column size to center the content -->
              <div class="detail mb-4">
                  <h1>Your <span class="text-primary">Profile</span></h1>
                  <div class="card mb-4">
                      <div class="card-body">
                          <div class="row">
                              <div class="col-sm-3">
                                  <p class="mb-0"><strong>Full Name</strong></p>
                              </div>
                              <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $profile->name }}</p>
                              </div>
                          </div>
                          <hr>
                          <div class="row">
                              <div class="col-sm-3">
                                  <p class="mb-0"><strong>Email</strong></p>
                              </div>
                              <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $profile->email }}</p>
                              </div>
                          </div>
                          <hr>
                          <div class="row">
                              <div class="col-sm-3">
                                  <p class="mb-0"><strong>Phone</strong></p>
                              </div>
                              <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $profile->phone_number }}</p>
                              </div>
                          </div>
                          <hr>
                          <div class="row">
                              <div class="col-sm-3">
                                  <p class="mb-0"><strong>Address</strong></p>
                              </div>
                              <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $profile->address }}</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
