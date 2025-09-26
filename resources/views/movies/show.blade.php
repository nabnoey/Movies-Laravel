@extends('layouts.app')

@section('content')
<style>
    /* Star Rating System */
    .rating {
        display: inline-block;
        direction: rtl; /* Right-to-left to make stars fill from left-to-right */
        border: none;
        margin: 0;
        padding: 0;
    }
    .rating > input {
        display: none; /* Hide the actual radio buttons */
    }
    .rating > label {
        font-size: 2rem;
        color: #D3D3D3; /* Grey for empty stars */
        cursor: pointer;
        transition: color 0.2s;
    }
    /* On hover, light up this star and all previous ones */
    .rating > label:hover,
    .rating > label:hover ~ label {
        color: #FFD700; /* Yellow on hover */
    }
    /* For selected star, light up this star and all previous ones */
    .rating > input:checked ~ label {
        color: #FFD700; /* Yellow for selected */
    }

    /* Static Star Display */
    .static-rating {
        font-size: 1.2rem;
        color: #D3D3D3; /* Default empty star color */
    }
    .static-rating .filled {
        color: #FFD700; /* Yellow for filled stars */
    }
    .avg-rating-display {
        font-size: 1.5rem;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img src="{{ $movie->poster_image_url }}" class="img-fluid rounded" alt="{{ $movie->title }}">
        </div>
        <div class="col-md-8">
            <h1>{{ $movie->title }}</h1>

            <!-- Average Rating -->
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
            <hr>
            
            <h5>Categories:</h5>
            @if($movie->categories->count() > 0)
                @foreach($movie->categories as $category)
                    <span class="badge bg-primary">{{ $category->name }}</span>
                @endforeach
            @else
                <p>No categories assigned.</p>
            @endif

            <div class="mt-4">
                @auth
                    @if(auth()->user()->favoriteMovies->contains($movie))
                        <form action="{{ route('movies.unfavorite', $movie) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove from Favorites</button>
                        </form>
                    @else
                        <form action="{{ route('movies.favorite', $movie) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Add to Favorites</button>
                        </form>
                    @endif
                @endauth
                @guest
                    <p><a href="{{ route('login') }}">Log in</a> to add this movie to your favorites.</p>
                @endguest
            </div>

            <hr>

            <!-- Comments Section -->
            <div class="mt-5">
                <h4>Comments</h4>

                @auth
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">แสดงความคิดเห็น</h5>

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

                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                            
                            <!-- Rating Input -->
                            <div class="mb-3">
                                <label class="form-label">ให้คะแนน:</label>
                                <div class="rating">
                                    <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="5 stars">&#9733;</label>
                                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars">&#9733;</label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars">&#9733;</label>
                                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars">&#9733;</label>
                                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star">&#9733;</label>
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
                        </div>
                    </div>
                @empty
                    <p>ยังไม่มีความคิดเห็น</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
