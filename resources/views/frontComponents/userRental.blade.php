<section id="process" class=" position-relative overflow-hidden">
    <div class="pattern-overlay pattern-right position-absolute">
        <img src="{{asset('frontend/images/hero-pattern-right.png')}}" alt="pattern">
    </div>
    <div class="pattern-overlay pattern-left position-absolute">
        <img src="{{asset('frontend/images/hero-pattern-left.png')}}" alt="pattern">
    </div>
    <div class="hero-content container text-center">
        <div class="row">
            <div class="detail mb-4">
                <h1 class="">Your <span class="text-primary"> Rental History </span> </h1>
               
            </div>
            <div class="container">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Car Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rentals as $index => $rental)
                            @php
                                $currentDate = \Carbon\Carbon::now();
                                $startDate = \Carbon\Carbon::parse($rental->start_date);
                                $endDate = \Carbon\Carbon::parse($rental->end_date);
                                $status = '';
        
                                if ($currentDate->lt($startDate)) {
                                    $status = 'Cancel';
                                } elseif ($currentDate->between($startDate, $endDate)) {
                                    $status = 'Ongoing';
                                } elseif ($currentDate->gt($endDate)) {
                                    $status = 'Complete';
                                }
                            @endphp
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $rental->car->name }}</td>
                                <td>{{ $rental->start_date }}</td>
                                <td>{{ $rental->end_date }}</td>
                                <td>
                                    @if($status == 'Cancel')
                                   
                                        <button class="btn btn-danger deleteBtn" data-id="{{ $rental->id }}">Cancel</button>
                                    @else
                                       {{ $status }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>



<!-- Include the existing Delete Modal from another Blade file -->
<br><br><br><br><br><br>
<hr>

<script>
    // Event listener for delete buttons
    $('.deleteBtn').on('click',function () {
            let id= $(this).data('id');
            $("#delete-modal").modal('show');
            $("#deleteID").val(id);
        })
</script>
