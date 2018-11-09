
<div class="card-header">My courses</div>

<div class="card-body">
    <div class="row">

        @if(count($contracts) < 1)

            <p class="text-center w-100">You haven't active courses</p>

        @endif
        @foreach($contracts as $contract)

            <div class="col-sm-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">{{$contract->course()->name}}</h5>
                        <p class="card-text">
                            <p class="unic_number">Payment number: <b>{{$contract->number}}</b></p>
                            <p class="price">Price: {{$contract->price}} €</p>
                            <p class="start_date">Start date: @dateFormat($contract->course()->start_date)</p>
                            <p class="end_date">End date: @dateFormat($contract->course()->end_date)</p>

                            @if($contract->status == 'not_paid')
                            <p class="expire">Reservation expires: @dateFormat($contract->expired_at)</p>
                                <div class="alert alert-warning" role="alert">
                                    Not paid
                                </div>
                            </p>
                            @elseif($contract->status == 'paid')
                                <div class="alert alert-success" role="alert">
                                    Paid
                                </div>
                            @elseif($contract->status == 'prepaid')
                            <div class="alert alert-primary" role="alert">
                                    Prepaid
                            </div>
                            @elseif($contract->status == 'expired')
                            <div class="alert alert-error" role="alert">
                                Expired
                            </div>
                            @endif
                        </p>

                        @if($contract->status != 'not_paid' && $contract->status != 'expired')
                        <hr>
                        <h6>Documents:</h6>
                        <ul>
                            <li><a href="{{route('downloadPdf', ['id'=>$contract->number])}}">Download invoice file</a></li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>

        @endforeach



    </div>
</div>
@if($next_course !== false)

    <div class="modal" id="offerModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Do you want register on next level course?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>We want to offer you to register for the next course: <b>{{$next_course->name}}</b>. Want to do this?</p>
                    <div class="modal-footer">
                        <a href="{{route('course', $next_course->id)}}" class="btn btn-primary btn-accept">Register</a>
                        <button type="button" class="btn btn-secondary btn-refuse" data-dismiss="modal">Refuse</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif
