@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 fw-bold text-dark">📂 Categories</h2>

    <div class="row g-3">
        @foreach ($categories as $category)
            <div class="col-md-4">
                <a href="{{ route('categories.show', $category->id) }}" class="category-card d-block p-4 rounded-4 text-center text-white fw-semibold">
                    {{ $category->name }}
                </a>
            </div>
        @endforeach
    </div>
</div>

<style>
body {
    background: #f5f6f8; /* light gray background */
    font-family: 'Prompt', sans-serif;
}

/* Category cards */
.category-card {
    background: #666; /* dark gray */
    transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    text-decoration: none;
}
.category-card:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    background: #555; /* lighter gray on hover */
}

/* Heading */
h2 {
    color: #111; /* black text */
}
</style>
@endsection
