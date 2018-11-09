<div class="row">
@foreach ($categories as $category)


        <div class="course-category card col-lg-2dot4 col-md-4">
            <div class="card-body">
                <h5 class="card-title">{{ $category->name }}</h5>
                <a href="{{ route('category', ['id'=>$category->id]) }}" class="btn btn-primary">Read More</a>
            </div>
        </div>


@endforeach
</div>