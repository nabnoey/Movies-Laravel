@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm rounded-4" style="background-color: #f5f5f5; padding: 30px;">
        <h2 class="mb-4" style="color: #333;">Add New Movie</h2>
        <form method="POST" action="{{ route('admin.movies.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" style="color: #555;">Title</label>
                <input type="text" name="title" class="form-control" style="background-color: #e8e8e8; color: #222;" required>
            </div>
            <div class="mb-3">
                <label class="form-label" style="color: #555;">Description</label>
                <textarea name="description" class="form-control" style="background-color: #e8e8e8; color: #222;" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" style="color: #555;">Poster URL</label>
                <input type="text" name="poster_image_url" class="form-control" style="background-color: #e8e8e8; color: #222;" required>
            </div>
            <div class="mb-3">
                <label class="form-label" style="color: #555;">Trailer URL</label>
                <input type="text" name="trailer_url" class="form-control" style="background-color: #e8e8e8; color: #222;">
            </div>
            <div class="mb-3">
                <label class="form-label" style="color: #555;">Categories</label>
                <select class="form-select select2" name="categories[]" multiple style="background-color: #e8e8e8; color: #222;">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" style="color: #555;">Release Date</label>
                <input type="date" name="release_date" class="form-control" style="background-color: #e8e8e8; color: #222;" required>
            </div>
            <button type="submit" class="btn btn-dark" style="background-color: #555; color: #f5f5f5;">Save</button>
        </form>
    </div>
</div>

<!-- Select2 CSS & JS CDN -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
      $('.select2').select2({
        placeholder: "Select categories",
        allowClear: true,
        width: '100%'
      });
    });
</script>
@endsection
