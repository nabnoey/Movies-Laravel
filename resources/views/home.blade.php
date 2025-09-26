@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
    <div class="card shadow-sm border-0 rounded-3" style="background-color: #f5f5f5;">
        <div class="card-header bg-gray-500 text-gray-800 fw-bold">
            <i class="bi bi-list"></i> เมนู
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item border-0" style="background-color: #f5f5f5;">
                <a href="{{ route('categories.list') }}" class="text-decoration-none text-gray-800 hover:text-gray-900">
                    📂 หมวดหมู่หนัง
                </a>
            </li>

            @auth
                @if(auth()->user()->role === 'admin')
                    <li class="list-group-item border-0" style="background-color: #f5f5f5;">
                        <a href="{{ route('admin.movies.index') }}" class="text-decoration-none text-gray-800 hover:text-gray-900">
                            🎬 เพิ่มหนัง
                        </a>
                    </li>
                @endif
                <li class="list-group-item border-0" style="background-color: #f5f5f5;">
                    <a href="{{ route('favorites.index') }}" class="text-decoration-none text-gray-800 hover:text-gray-900">
                        ⭐ รายการโปรด
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</div>
        <!-- Main Content -->
        <div class="col-md-9">
            <h2 class="mb-4 fw-bold text-gray-800">🎥 หนังที่น่าสนใจ</h2>
            <div class="row g-4">
                @foreach ($movies as $movie)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100 rounded-4 hover-card" style="background-color: #f8f8f8;">
                        <img src="{{ $movie->poster_image_url }}" 
                             class="card-img-top rounded-top-4" 
                             alt="{{ $movie->title }}" 
                             style="height: 280px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-gray-800">{{ $movie->title }}</h5>
                            <p class="card-text text-gray-600">
                                {{ \Illuminate\Support\Str::limit($movie->description, 60) }}
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('movies.show', $movie->id) }}" 
                                   class="btn btn-dark w-100 rounded-pill">
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
        background: #f5f5f5; /* โทนพื้นหลังเทาอ่อน */
    }
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .btn-dark {
        background-color: #555;
        color: #f5f5f5;
        border: none;
        transition: background-color 0.2s ease;
    }
    .btn-dark:hover {
        background-color: #444;
    }
</style>
@endsection
