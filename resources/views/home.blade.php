@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-dark text-white fw-bold">
                    <i class="bi bi-list"></i> เมนู
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item border-0">
                        <a href="{{ route('categories.list') }}" class="text-decoration-none text-dark">
                            📂 หมวดหมู่หนัง
                        </a>
                    </li>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="list-group-item border-0">
                                <a href="{{ route('admin.movies.index') }}" class="text-decoration-none text-dark">
                                    🎬 เพิ่มหนัง
                                </a>
                            </li>
                        @endif
                        <li class="list-group-item border-0">
                            <a href="{{ route('favorites.index') }}" class="text-decoration-none text-dark">
                                ⭐ รายการโปรด
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <h2 class="mb-4 fw-bold text-dark">🎥 หนังที่น่าสนใจ</h2>
            <div class="row g-4">
                @foreach ($movies as $movie)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100 rounded-4 hover-card">
                        <img src="{{ $movie->poster_image_url }}" 
                             class="card-img-top rounded-top-4" 
                             alt="{{ $movie->title }}" 
                             style="height: 280px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark">{{ $movie->title }}</h5>
                            <p class="card-text text-muted">
                                {{ \Illuminate\Support\Str::limit($movie->description, 60) }}
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('admin.movies.show', $movie->id) }}" 
                                   class="btn btn-outline-dark w-100 rounded-pill">
                                   ดูรายละเอียด
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- เพิ่ม custom style --}}
<style>
    body {
        background: #f5f6f8; /* โทนพื้นหลัง modern */
    }
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection
