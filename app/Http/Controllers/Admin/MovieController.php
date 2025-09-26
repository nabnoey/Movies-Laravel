<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;

class MovieController extends Controller
{
    public function index() {
        $movies = Movie::all();
        return view('admin.movies.index', compact('movies'));
    }

    public function category($id) {
        $category = Category::findOrFail($id);
        $movies = $category->movies; // ดึงหนังในหมวด
        return view('admin.category.show', compact('category', 'movies'));
    }

public function show($id)
{
    $movie = Movie::with('comments.user', 'categories')->findOrFail($id);
    return view('movies.show', compact('movie'));
}



    public function create() {
        $categories = Category::all();
        return view('admin.movies.create', compact('categories'));
    }

   public function store(Request $request) {
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'poster_image_url' => 'nullable|string',
        'release_date' => 'nullable|date',
        'categories' => 'array', // ตรวจสอบว่า categories เป็น array
    ]);

    $movie = Movie::create($request->only(['title', 'description', 'poster_image_url', 'release_date']));
    $movie->categories()->sync($request->categories);

    return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully.');
}

    public function edit($id) {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, $id) {
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'poster_image_url' => 'nullable|string',
        'release_date' => 'nullable|date',
        'categories' => 'array', // ตรวจสอบว่า categories เป็น array
    ]);

    $movie = Movie::findOrFail($id);
    $movie->update($request->only(['title', 'description', 'poster_image_url', 'release_date']));
    $movie->categories()->sync($request->categories); // อัปเดตความสัมพันธ์หมวดหมู่

    return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully.');
}

    public function destroy($id) {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully.');
    }
}
