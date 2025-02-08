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
            'content' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:comments,id' // Ensure parent_id is valid
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->post_id = $postId;
        $comment->parent_id = $request->parent_id ?? null; // Assign parent_id correctly
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully!');
    }




    public function showComments(Post $post)
    {
        return view('comments.index', compact('post'));
    }
}
