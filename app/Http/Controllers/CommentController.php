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



    public function like(Post $post, $commentId = null)
    {
        $user = auth()->user();
        $likeable = $commentId ? Comment::find($commentId) : $post;

        // Remove the opposite reaction
        if ($commentId) {
            // Remove dislike if the user disliked the comment
            $likeable->likes()->where('user_id', $user->id)->where('type', 'dislike')->delete();
        } else {
            // Remove dislike if the user disliked the post
            $likeable->likes()->where('user_id', $user->id)->where('type', 'dislike')->delete();
        }

        // Add the like or remove if already liked
        $existingLike = $likeable->likes()->where('user_id', $user->id)->where('type', 'like')->first();
        if ($existingLike) {
            $existingLike->delete();
        } else {
            $likeable->likes()->create([
                'user_id' => $user->id,
                'type' => 'like',
            ]);
        }

        return response()->json([
            'likes_count' => $likeable->likes->where('type', 'like')->count(),
            'dislikes_count' => $likeable->likes->where('type', 'dislike')->count(),
        ]);
    }

    public function dislike(Post $post, $commentId = null)
    {
        $user = auth()->user();
        $likeable = $commentId ? Comment::find($commentId) : $post;

        // Remove the opposite reaction
        if ($commentId) {
            // Remove like if the user liked the comment
            $likeable->likes()->where('user_id', $user->id)->where('type', 'like')->delete();
        } else {
            // Remove like if the user liked the post
            $likeable->likes()->where('user_id', $user->id)->where('type', 'like')->delete();
        }

        // Add the dislike or remove if already disliked
        $existingDislike = $likeable->likes()->where('user_id', $user->id)->where('type', 'dislike')->first();
        if ($existingDislike) {
            $existingDislike->delete();
        } else {
            $likeable->likes()->create([
                'user_id' => $user->id,
                'type' => 'dislike',
            ]);
        }

        return response()->json([
            'likes_count' => $likeable->likes->where('type', 'like')->count(),
            'dislikes_count' => $likeable->likes->where('type', 'dislike')->count(),
        ]);
    }
}
