<div class="row">

@foreach($courses as $course)

    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{$course->name}}</h5>
                <p class="card-text">
                    <p>{{$category->short_description['how_often']}}</p>
                    <p>Duration: {{$category->short_description['duration']}} weeks</p>
                    <p>Price from: {{$category->prices['price_1']}} Euro</p>
                    <p>Start: @dateFormat($course->start_date)</p>
                </p>
                <a href="{{ route('course',['id'=> $course->id]) }}" class="btn btn-primary">Register</a>
            </div>
        </div>
    </div>

@endforeach

</div>