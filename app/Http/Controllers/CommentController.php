<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'movie_id' => 'required|exists:movies,id',
        ]);

        Comment::create([
            'user_id' => Auth::id(),  // เปลี่ยนจาก auth()->id() เป็น Auth::id()
            'movie_id' => $request->movie_id,
            'body' => $request->body,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'body' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $comment->update($request->only('body', 'rating'));

        return redirect()->route('movies.show', $comment->movie_id);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back();
    }
}
