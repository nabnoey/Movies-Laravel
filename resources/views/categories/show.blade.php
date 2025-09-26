@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Header -->
    <div class="text-center mb-5">
       <h2 class="fw-bold display-5">🎬 Movies in {{ $category->name }}</h2>

        <div class="mx-auto" style="width: 100px; height: 3px; background: linear-gradient(90deg, #ff512f, #dd2476); border-radius: 2px;"></div>
    </div>

    <!-- Movies Grid -->
    <div class="row g-4">
        @if ($movies->isEmpty())
            <div class="col-12 text-center">
                <p class="text-muted fs-5">No movies found in this category.</p>
            </div>
        @else
            @foreach ($movies as $movie)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="movie-card position-relative overflow-hidden rounded-4 shadow-lg">
                        <img src="{{ $movie->poster_image_url }}" alt="{{ $movie->title }}" class="img-fluid w-100">
                        <div class="overlay d-flex flex-column justify-content-end p-3">
                            <h5 class="text-white fw-bold">{{ $movie->title }}</h5>
                            <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-sm btn-gradient mt-2"> ดูรายละเอียด</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Back Button -->
  <div class="text-center mt-5">
    <a href="{{ route('categories.list') }}" class="btn btn-lg btn-outline-secondary">← Back to Categories</a>
</div>

</div>

<style>
/* Gradient text */
.text-gradient {
    background: linear-gradient(90deg, #ff512f, #dd2476);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Movie card hover */
.movie-card {
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.movie-card:hover {
    transform: scale(1.05);
    box-shadow: 0 20px 30px rgba(0,0,0,0.25);
}

/* Overlay for title and button */
.movie-card .overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.movie-card:hover .overlay {
    opacity: 1;
}

/* Gradient buttons */
.btn-gradient {
    background: linear-gradient(90deg, #ff512f, #dd2476);
    color: white;
    border: none;
}
.btn-gradient:hover {
    background: linear-gradient(90deg, #dd2476, #ff512f);
}
</style>
@endsection
