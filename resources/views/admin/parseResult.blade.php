<section class="content">

    <div class="container">

        @foreach($statuses as $key => $status)
            @if($status['status'] == 'payed')
                <div class="alert alert-success" role="alert">Contract ID {{$key}} succefully payed <a target="_blank" href="{{$status['link_user']}}">(Show user)</a></div>
            @elseif($status['status'] == 'prepayed')
                <div class="alert alert-warning" role="alert">Contract ID {{$key}} succefully payed <a target="_blank" href="{{$status['link_user']}}">(Show user)</a></div>
            @elseif($status['status'] == 'noPlaces')
                <div class="alert alert-danger" role="alert">Contract ID {{$key}} succefully payed but we can't added him to course <a target="_blank" href="{{$status['link_user']}}">(Show user)</a></div>
            @else
                <div class="alert alert-danger" role="alert">Contract ID {{$key}} wrong summ {{$status['amount']}} EURO <a target="_blank" href="{{$status['link_user']}}">(Show user)</a></div>
            @endif
        @endforeach

    </div>

</section>
