<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100">
    <div class="container mx-auto p-4">
        <!-- Back Button -->
        <a href="{{ route('posts.index') }}"
            class="inline-block mb-6 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
            Back to Posts
        </a>

        <!-- Post Container -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <!-- Publisher Info -->
            <div class="flex items-center mb-6">
                <!-- Profile Photo -->
                <a href="{{ route('profile.show', $post->user->id) }}" class="flex items-center">
                    @if ($post->user->profile_photo)
                        <img src="{{ asset('storage/' . $post->user->profile_photo) }}" alt="{{ $post->user->name }}"
                            class="w-10 h-10 rounded-full object-cover mr-3">
                    @else
                        <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center mr-3">
                            <span class="text-gray-300 text-sm">{{ substr($post->user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </a>

                <!-- Publisher Name and Timestamp -->
                <div>
                    <a href="{{ route('profile.show', $post->user->id) }}" class="text-blue-400 hover:underline">
                        {{ $post->user->name }}
                    </a>
                    <p class="text-sm text-gray-400">
                        {{ $post->created_at->format('F j, Y \a\t g:i A') }} •
                        {{ $post->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>

            <!-- Post Title -->
            <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

            <!-- Post Content -->
            <p class="text-gray-300 break-words whitespace-pre-wrap">{{ $post->content }}</p>

            <!-- Post Image -->
            @if ($post->post_photo)
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('storage/' . $post->post_photo) }}" alt="Post Image"
                        class="max-w-full max-h-[500px] object-contain rounded-lg">
                </div>
            @endif

            <h2 class="text-xl font-semibold mt-8 mb-4">Comments</h2>

            <div class="space-y-4">
                @foreach ($post->comments->take(3) as $comment)
                    <div class="bg-gray-700 p-4 rounded-lg flex items-start">
                        <!-- Profile Photo -->
                        <a href="{{ route('profile.show', $comment->user->id) }}" class="flex items-center">
                            @if ($comment->user->profile_photo)
                                <img src="{{ asset('storage/' . $comment->user->profile_photo) }}"
                                    alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                            @else
                                <div
                                    class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-gray-300 text-sm mr-3">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                            @endif
                        </a>

                        <!-- Comment Content -->
                        <div>
                            <p class="text-sm text-gray-300">
                                <a href="{{ route('profile.show', $comment->user->id) }}"
                                    class="font-semibold hover:text-blue-400">
                                    {{ $comment->user->name }}
                                </a>
                                • {{ $comment->created_at->diffForHumans() }}
                            </p>
                            <p class="text-gray-200 mt-2">{{ $comment->content }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($post->comments->count() > 3)
                <div class="mt-4">
                    <a href="{{ route('posts.comments', $post->id) }}"
                        class="text-blue-400 hover:text-blue-300 transition duration-200">
                        View all comments ({{ $post->comments->count() }})
                    </a>
                </div>
            @endif

            @if (Auth::check())
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-6">
                    @csrf
                    <textarea name="content" rows="3" class="w-full p-3 rounded-lg bg-gray-800 text-gray-100"
                        placeholder="Write a comment..." required></textarea>
                    <button type="submit"
                        class="mt-3 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Post Comment</button>
                </form>
            @else
                <p class="text-gray-400 mt-6">You must <a href="{{ route('login') }}" class="text-blue-400">log in</a>
                    to comment.</p>
            @endif

            <!-- Edit/Delete Buttons (for the post owner) -->
            <div class="mt-6">
                @if ($post->user_id === Auth::id())
                    <a href="{{ route('posts.edit', $post) }}"
                        class="text-yellow-400 hover:text-yellow-300 transition duration-200">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-red-400 hover:text-red-300 ml-4 transition duration-200">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
