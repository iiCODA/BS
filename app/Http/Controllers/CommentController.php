<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment added!');
    }


    public function showComments(Post $post)
    {
        return view('comments.index', compact('post'));
    }
}
