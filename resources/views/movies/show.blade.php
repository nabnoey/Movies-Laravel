@extends('layouts.app')

@section('content')
<style>
    /* Star Rating System */
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

    /* Static Star Display */
    .static-rating {
        font-size: 1.2rem;
        color: #D3D3D3;
    }
    .static-rating .filled {
        color: #FFD700;
    }
    .avg-rating-display {
        font-size: 1.5rem;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <!-- Poster -->
        <div class="col-md-4">
            <img src="{{ $movie->poster_image_url }}" class="img-fluid rounded" alt="{{ $movie->title }}">
        </div>

        <!-- Movie Info -->
        <div class="col-md-8">
            <h1 class="fw-bold">{{ $movie->title }}</h1>

            @php
                $averageRating = $movie->comments->avg('rating');
            @endphp
            <div class="static-rating avg-rating-display mb-2" title="Average rating: {{ number_format($averageRating, 1) }} out of 5">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= round($averageRating) ? 'filled' : '' }}">&#9733;</span>
                @endfor
                <span class="ms-2 h5 align-middle">({{ number_format($averageRating, 1) }})</span>
            </div>

            <p class="text-muted">Released on: {{ $movie->release_date }}</p>
            <hr>
            <p>{{ $movie->description }}</p>

            <!-- Trailer and Favorites Buttons -->
            <div class="mt-3 d-flex align-items-center gap-2">
                @if($movie->trailer_url)
                    <a href="{{ route('movies.trailer', $movie->id) }}" class="btn btn-info">
                        <i class="fas fa-play"></i> Watch Trailer
                    </a>
                @endif

                @auth
                    @if(auth()->user()->favoriteMovies->contains($movie))
                        <form action="{{ route('movies.unfavorite', $movie) }}" method="POST" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove from Favorites</button>
                        </form>
                    @else
                        <form action="{{ route('movies.favorite', $movie) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-success">Add to Favorites</button>
                        </form>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-secondary">Log in to Favorite</a>
                @endguest
            </div>

            <hr>

            <!-- Categories -->
            <h5>Categories:</h5>
            @if($movie->categories->count() > 0)
                @foreach($movie->categories as $category)
                    <span class="badge bg-primary">{{ $category->name }}</span>
                @endforeach
            @else
                <p>No categories assigned.</p>
            @endif

            <hr>

            <!-- Comments Section -->
            <div class="mt-5">
                <h4>Comments</h4>

                <!-- Add Comment -->
                @auth
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">แสดงความคิดเห็น</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="movie_id" value="{{ $movie->id }}">

                            <!-- Rating -->
                            <div class="mb-3">
                                <label class="form-label">ให้คะแนน:</label>
                                <div class="rating">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" required>
                                        <label for="star{{$i}}" title="{{$i}} stars">&#9733;</label>
                                    @endfor
                                </div>
                            </div>

                            <div class="mb-3">
                                <textarea class="form-control" name="body" rows="3" placeholder="เขียนคอมเมนต์..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">ส่งความคิดเห็น</button>
                        </form>
                    </div>
                </div>
                @endauth

                @guest
                    <p><a href="{{ route('login') }}">เข้าสู่ระบบเพื่อแสดงความคิดเห็น</a></p>
                @endguest

                <!-- Display Comments -->
                @auth
                    @forelse ($movie->comments->sortByDesc('created_at') as $comment)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title fw-bold">{{ $comment->user->name }}</h6>
                                <div class="static-rating mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $comment->rating ? 'filled' : '' }}">&#9733;</span>
                                    @endfor
                                </div>
                                <p class="card-text">{{ $comment->body }}</p>
                                <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>

                                <div class="mt-2 flex items-center space-x-2">
                                    <!-- Like button -->
                                    @if(auth()->user()->role === 'user' && auth()->id() !== $comment->user_id)
                                        <form action="{{ route('comments.like', $comment->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                👍 Like ({{ $comment->likes_count ?? 0 }})
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Edit button -->
                                    @if(auth()->id() === $comment->user_id)
                                        <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    @endif

                                    <!-- Delete button -->
                                    @if(auth()->user()->role === 'admin')
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>ยังไม่มีความคิดเห็น</p>
                    @endforelse
                @endauth
                @guest
                    <p><a href="{{ route('login') }}">เข้าสู่ระบบเพื่อดูความคิดเห็น</a></p>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
