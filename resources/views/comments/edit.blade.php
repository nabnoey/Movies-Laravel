@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold">Edit Your Comment</h2>
    <hr>

    <div class="card">
        <div class="card-body">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Rating Input -->
                <div class="mb-3">
                    <label class="form-label">ให้คะแนน:</label>
                    <div class="rating">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" {{ $comment->rating == $i ? 'checked' : '' }} required>
                            <label for="star{{$i}}" title="{{$i}} stars">&#9733;</label>
                        @endfor
                    </div>
                </div>

                <div class="mb-3">
                    <textarea class="form-control" name="body" rows="4" required>{{ $comment->body }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update Comment</button>
                <a href="{{ route('movies.show', $comment->movie_id) }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>

<style>
    /* Star Rating */
    .rating {
        display: inline-block;
        direction: rtl;
    }
    .rating > input {
        display: none;
    }
    .rating > label {
        font-size: 2rem;
        color: #D3D3D3;
        cursor: pointer;
        transition: color 0.2s;
    }
    .rating > label:hover,
    .rating > label:hover ~ label {
        color: #FFD700;
    }
    .rating > input:checked ~ label {
        color: #FFD700;
    }
</style>
@endsection
ป