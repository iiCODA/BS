<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type');

        if ($type == 'posts') {
            $posts = Post::where('title', 'like', "%$query%")->paginate(10);
            return view('search.results', compact('posts', 'query', 'type'));
        } elseif ($type == 'users') {
            $users = User::where('name', 'like', "%$query%")->paginate(10);
            return view('search.results', compact('users', 'query', 'type'));
        }

        return view('search.results', compact('query', 'type'));
    }
}
