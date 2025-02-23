<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-900 text-gray-100">
    <div class="container mx-auto p-6 pb-20">
        <!-- Back Button -->
        <a href="{{ route('posts.index') }}"
            class="inline-block mb-6 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
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
        <div class="space-y-4 mt-4 overflow-auto max-h-[60vh] pb-24">
            @foreach ($post->comments->where('parent_id', null) as $comment)
                <div class="bg-gray-700 p-4 rounded-lg mb-2">
                    <!-- Parent Comment -->
                    <div class="flex items-start">
                        <!-- Profile Photo -->
                        @if ($comment->user->profile_photo)
                            <img src="{{ asset('storage/' . $comment->user->profile_photo) }}"
                                class="w-10 h-10 rounded-full object-cover mr-3">
                        @else
                            <div
                                class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-gray-300 text-sm">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                        @endif

                        <!-- Comment Content -->
                        <div class="flex-1">
                            <p class="text-sm text-gray-300">
                                <strong>{{ $comment->user->name }}</strong> •
                                {{ $comment->created_at->diffForHumans() }}
                            </p>
                            <p class="text-gray-200 mt-1">{{ $comment->content }}</p>

                            <!-- Like/Dislike buttons -->
                            <div class="flex items-center space-x-4 mt-2">
                                <!-- Like Button -->
                                <button type="button" class="flex items-center text-blue-500"
                                    onclick="likeComment(event, {{ $post->id }}, {{ $comment->id }})">
                                    <!-- Thumbs Up Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 9l2-2m0 0l-2-2m2 2H5m9 7h3a4 4 0 004-4V7a4 4 0 00-4-4h-1a2 2 0 00-1.732.986L10 5l-1-2-2 4V15a4 4 0 004 4h1z" />
                                    </svg>
                                    Like (<span
                                        id="like-count-comment-{{ $comment->id }}">{{ $comment->likes->where('type', 'like')->count() }}</span>)
                                </button>

                                <!-- Dislike Button -->
                                <button type="button" class="flex items-center text-red-500"
                                    onclick="dislikeComment(event, {{ $post->id }}, {{ $comment->id }})">
                                    <!-- Thumbs Down Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 15l-2 2m0 0l2 2m-2-2H5m9-7h3a4 4 0 004-4V7a4 4 0 00-4-4h-1a2 2 0 00-1.732.986L10 5l-1-2-2 4V15a4 4 0 004 4h1z" />
                                    </svg>
                                    Dislike (<span
                                        id="dislike-count-comment-{{ $comment->id }}">{{ $comment->likes->where('type', 'dislike')->count() }}</span>)
                                </button>
                            </div>

                            <!-- Reply Button -->
                            <button class="text-blue-400 text-sm mt-2" onclick="toggleReplyForm({{ $comment->id }})">
                                Reply
                            </button>

                            <!-- Reply Form -->
                            <form action="{{ route('comments.store', $post->id) }}" method="POST"
                                class="mt-2 hidden reply-form-{{ $comment->id }}">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <textarea name="content" rows="2" class="w-full p-2 bg-gray-800 text-gray-100 rounded"
                                    placeholder="Write a reply..." required></textarea>
                                <button type="submit"
                                    class="mt-2 bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded">
                                    Reply
                                </button>
                            </form>

                            <!-- Display Nested Replies Recursively -->
                            @if ($comment->replies->count() > 0)
                                <div class="ml-10 mt-3 border-l-2 border-gray-600 pl-4">
                                    @foreach ($comment->replies as $reply)
                                        @include('comments.comment', ['comment' => $reply])
                                    @endforeach
                                </div>
                            @endif
                        </div>
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

    <script>
        // Toggle Reply Form
        function toggleReplyForm(commentId) {
            document.querySelector('.reply-form-' + commentId).classList.toggle('hidden');
        }

        // Function to like a comment
        function likeComment(event, postId, commentId) {
            event.preventDefault();

            fetch(`/posts/${postId}/comments/${commentId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById(`like-count-comment-${commentId}`).innerText = data.likes_count;
                    document.getElementById(`dislike-count-comment-${commentId}`).innerText = data.dislikes_count;
                })
                .catch(error => console.error('Error:', error));
        }

        // Function to dislike a comment
        function dislikeComment(event, postId, commentId) {
            event.preventDefault();

            fetch(`/posts/${postId}/comments/${commentId}/dislike`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById(`like-count-comment-${commentId}`).innerText = data.likes_count;
                    document.getElementById(`dislike-count-comment-${commentId}`).innerText = data.dislikes_count;
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>
