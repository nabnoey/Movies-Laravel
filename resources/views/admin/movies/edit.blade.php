@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Movie</h1>
    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $movie->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $movie->description }}</textarea>
        </div>

         <div class="mb-3">
            <label for="poster_image_url" class="form-label">โปสเตอร์ (URL)</label>
            <input type="text" name="poster_image_url" class="form-control" required>
        </div>

        
        <button type="submit" class="btn btn-primary">Update Movie</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
