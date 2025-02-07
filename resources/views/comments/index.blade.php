<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100">
    <div class="container mx-auto p-6 pb-20"> <!-- Ensure padding-bottom for fixed comment box -->
        <!-- Back Button -->
        <a href="{{ route('posts.index') }}"
            class="inline-block mb-6 text-blue-400 hover:text-blue-300 transition duration-200">
            Back to Posts
        </a>

        <!-- Post Details -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-2xl font-semibold mb-2">{{ $post->title }}</h2>
            <p class="text-gray-300">{{ $post->content }}</p>
        </div>

        <!-- Comments Section -->
        <h2 class="text-xl font-semibold mb-4">All Comments</h2>

        <!-- Scrollable Comments Section -->
        <div class="space-y-4 mt-4 overflow-auto max-h-[60vh] pb-24"> <!-- Max height to keep comments scrollable -->
            @foreach ($post->comments as $comment)
                <div class="bg-gray-700 p-4 rounded-lg flex items-start">
                    <!-- Profile Photo -->
                    @if ($comment->user->profile_photo)
                        <img src="{{ asset('storage/' . $comment->user->profile_photo) }}"
                            alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                    @else
                        <div
                            class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-gray-300 text-sm mr-3">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                    @endif

                    <!-- Comment Content -->
                    <div>
                        <p class="text-sm text-gray-300">
                            <strong>{{ $comment->user->name }}</strong> • {{ $comment->created_at->diffForHumans() }}
                        </p>
                        <p class="text-gray-200 mt-1">{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Fixed Comment Input -->
    @if (Auth::check())
        <div class="fixed bottom-0 left-0 right-0 bg-gray-800 p-4 shadow-lg">
            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex items-center space-x-2">
                @csrf
                <textarea name="content" rows="2" class="flex-grow p-3 rounded-lg bg-gray-700 text-gray-100"
                    placeholder="Write a comment..." required></textarea>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Post</button>
            </form>
        </div>
    @else
        <div class="fixed bottom-0 left-0 right-0 bg-gray-800 p-4 shadow-lg text-center text-gray-400">
            You must <a href="{{ route('login') }}" class="text-blue-400">log in</a> to comment.
        </div>
    @endif

</body>

</html>
