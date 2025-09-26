<!DOCTYPE html>
<html lang="th" data-theme="pastel">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการหนังทั้งหมด</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-base-200 text-base-content font-sans p-6">
 @include('components.navbar')
    <div class="container mx-auto">
        <h1 class="text-4xl font-extrabold text-center text-primary mb-8">
            <span class="inline-block p-4 rounded-full bg-primary-content shadow-lg">🎥</span>
            รายการหนังทั้งหมด
        </h1>

     <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
@foreach ($movies as $movie)
    <a href="/movies/{{ $movie->id }}" class="card bg-base-100 shadow-xl transition-transform duration-300 hover:scale-105">
        <figure><img src="{{ $movie->poster_image_url }}" alt="{{ $movie->title }}" class="w-full h-auto object-cover"></figure>
        <div class="card-body p-6">
            <h2 class="card-title text-xl font-bold text-secondary">{{ $movie->title }}</h2>
        </div>
    </a>
            @endforeach
        </div>
    </div>

</body>
</html>