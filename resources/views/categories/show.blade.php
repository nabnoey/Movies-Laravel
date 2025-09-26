@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Movies in Category: {{ $category->name }}</h2>
    <hr>
    <div class="row">
        @if ($movies->isEmpty())
            <div class="col-12">
                <p>No movies found in this category.</p>
            </div>
        @else
            @foreach ($movies as $movie)
                <div class="col-md-4 mb-4">
                    <div class="acard h-100">
                        <img src="{{ $movie->poster_image_url }}" class="card-img-top" alt="{{ $movie->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                            <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <a href="{{ route('categories.list') }}" class="btn btn-secondary mt-3">Back to Categories</a>
</div>
@endsection