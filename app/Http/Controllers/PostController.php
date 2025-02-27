<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'post_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only('title', 'content');

        if ($request->hasFile('post_photo')) {
            $data['post_photo'] = $request->file('post_photo')->store('post_photos', 'public');
        }

        Auth::user()->posts()->create($data);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'post_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('title', 'content');

        if ($request->hasfile('post_photo')) {

            if ($post->post_photo) {
                Storage::disk('public')->delete($post->post_photo);
            }
            $data['post_photo'] = $request->file('post_photo')->store('post_photos', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function like(Post $post)
    {
        $user = auth()->user();

        // Check if the user has already liked the post
        $existingLike = $post->likes()->where('user_id', $user->id)->where('type', 'like')->first();

        // If the user has liked, we remove the like
        if ($existingLike) {
            $existingLike->delete();
        } else {
            // Remove any dislike first
            $post->likes()->where('user_id', $user->id)->where('type', 'dislike')->delete();

            // Add the like
            $post->likes()->create([
                'user_id' => $user->id,
                'type' => 'like',
            ]);
        }

        return response()->json([
            'likes_count' => $post->likes->where('type', 'like')->count(),
            'dislikes_count' => $post->likes->where('type', 'dislike')->count(),
        ]);
    }

    public function dislike(Post $post)
    {
        $user = auth()->user();

        // Check if the user has already disliked the post
        $existingDislike = $post->likes()->where('user_id', $user->id)->where('type', 'dislike')->first();

        // If the user has disliked, we remove the dislike
        if ($existingDislike) {
            $existingDislike->delete();
        } else {
            // Remove any like first
            $post->likes()->where('user_id', $user->id)->where('type', 'like')->delete();

            // Add the dislike
            $post->likes()->create([
                'user_id' => $user->id,
                'type' => 'dislike',
            ]);
        }

        return response()->json([
            'likes_count' => $post->likes->where('type', 'like')->count(),
            'dislikes_count' => $post->likes->where('type', 'dislike')->count(),
        ]);
    }

    public function share(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'nullable|string|max:500',
        ]);

        // Get the original post
        $originalPost = Post::findOrFail($request->post_id);

        // Create a new post with the shared content
        $sharedPost = Post::create([
            'user_id' => Auth::id(),
            'title' => 'Shared Post: ' . $originalPost->title,
            'content' => $request->content ?? 'Shared post from ' . $originalPost->user->name,
            'post_photo' => $originalPost->post_photo, // Optionally share the photo
            'shared_post_id' => $originalPost->id, // Reference the original post
        ]);

        return response()->json(['success' => true]);
    }
}
