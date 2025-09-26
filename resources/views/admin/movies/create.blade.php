@extends('layouts.app')

@section('content')
<div class="container">
    <h2>เพิ่มหนังใหม่</h2>
    <form method="POST" action="{{ route('admin.movies.store') }}">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">ชื่อหนัง</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">รายละเอียด</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="poster_image_url" class="form-label">โปสเตอร์ (URL)</label>
            <input type="text" name="poster_image_url" class="form-control" required>
        </div>

     <div class="mb-3">
    <label for="categories" class="form-label">ประเภท/หมวดหมู่</label>
    <select class="form-select" id="categories" name="categories[]" multiple>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>



        <div class="mb-3">
            <label for="release_date" class="form-label">วันฉาย</label>
            <input type="date" name="release_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
</div>
@endsection