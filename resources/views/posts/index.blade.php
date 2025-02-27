<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloGing</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-900 text-gray-100">
    <!-- Main Container -->
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gray-800 shadow-md p-4">
            <div class="container mx-auto flex justify-between items-center">
                <!-- Page Title -->
                <a href="{{ route('posts.index') }}">
                    <h1 class="text-2xl font-bold">BloGing</h1>
                </a>

                <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" class="flex items-center space-x-2">
                    <!-- Dropdown for selecting search type -->
                    <select name="type"
                        class="px-3 py-2 rounded-md border border-gray-300 bg-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="posts" {{ request('type') == 'posts' ? 'selected' : '' }}>Posts</option>
                        <option value="users" {{ request('type') == 'users' ? 'selected' : '' }}>Users</option>
                    </select>

                    <!-- Search input -->
                    <input type="text" name="query" placeholder="Enter search term" value="{{ request('query') }}"
                        class="px-4 py-2 rounded-md border border-gray-300 bg-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <!-- Submit button -->
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">
                        Search
                    </button>
                </form>

                <!-- User Dropdown -->
                <div class="relative">
                    <button class="flex items-center focus:outline-none">
                        <a href="{{ route('profile.show', Auth::user()->id) }}"
                            class="mr-2 text-blue-400 hover:underline">
                            {{ Auth::user()->name }}
                        </a>

                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-gray-700 rounded-md shadow-lg py-2 hidden">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-gray-100 hover:bg-gray-600">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-gray-100 hover:bg-gray-600">Log
                                Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto p-6">
            <!-- Create Post Button -->
            <a href="{{ route('posts.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded mb-6 inline-block hover:bg-blue-700 transition duration-200">
                Create New Post
            </a>

            <!-- Posts List -->
            <div class="space-y-6">
                @foreach ($posts as $post)
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                        <!-- Publisher Info -->
                        <div class="flex items-center mb-4">
                            <a href="{{ route('profile.show', $post->user->id) }}">
                                @if ($post->user->profile_photo)
                                    <img src="{{ asset('storage/' . $post->user->profile_photo) }}"
                                        alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                                @else
                                    <div
                                        class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center mr-3">
                                        <span
                                            class="text-gray-300 text-sm">{{ substr($post->user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </a>
                            <div>
                                <a href="{{ route('profile.show', $post->user->id) }}"
                                    class="text-blue-400 hover:underline">{{ $post->user->name }}</a>
                                <p class="text-sm text-gray-400">{{ $post->created_at->format('F j, Y \a\t g:i A') }} •
                                    {{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <!-- Post Title -->
                        <h2 class="text-2xl font-semibold mb-2">{{ $post->title }}</h2>

                        <!-- Post Content -->
                        <p class="text-gray-300">{{ Str::limit($post->content, 200) }}</p>

                        <!-- Post Image -->
                        @if ($post->post_photo)
                            <img src="{{ asset('storage/' . $post->post_photo) }}" alt="Post Image"
                                class="w-full h-64 object-cover rounded-lg mb-4">
                        @endif

                        <!-- Like/Dislike buttons with icons -->
                        <div class="mt-4 flex space-x-4">
                            <!-- Like Button -->
                            <button type="button" class="flex items-center text-blue-500"
                                onclick="likePost(event, {{ $post->id }})">
                                <!-- Thumbs Up Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 9l2-2m0 0l-2-2m2 2H5m9 7h3a4 4 0 004-4V7a4 4 0 00-4-4h-1a2 2 0 00-1.732.986L10 5l-1-2-2 4V15a4 4 0 004 4h1z" />
                                </svg>
                                Like (<span
                                    id="like-count-{{ $post->id }}">{{ $post->likes->where('type', 'like')->count() }}</span>)
                            </button>

                            <!-- Dislike Button -->
                            <button type="button" class="flex items-center text-red-500"
                                onclick="dislikePost(event, {{ $post->id }})">
                                <!-- Thumbs Down Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 15l-2 2m0 0l2 2m-2-2H5m9-7h3a4 4 0 004-4V7a4 4 0 00-4-4h-1a2 2 0 00-1.732.986L10 5l-1-2-2 4V15a4 4 0 004 4h1z" />
                                </svg>
                                Dislike (<span
                                    id="dislike-count-{{ $post->id }}">{{ $post->likes->where('type', 'dislike')->count() }}</span>)
                            </button>
                        </div>

                        <!-- Show One Comment (if exists) -->
                        @if ($post->comments->count() > 0)
                            <div class="bg-gray-700 p-4 rounded-lg mt-4 flex items-start">
                                @php
                                    $latestComment = $post->comments->first();
                                @endphp

                                <!-- Commenter Profile Photo -->
                                <a href="{{ route('profile.show', $latestComment->user->id) }}">
                                    @if ($latestComment->user->profile_photo)
                                        <img src="{{ asset('storage/' . $latestComment->user->profile_photo) }}"
                                            alt="{{ $latestComment->user->name }}"
                                            class="w-8 h-8 rounded-full object-cover mr-3">
                                    @else
                                        <div
                                            class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center text-gray-300 text-sm mr-3">
                                            {{ substr($latestComment->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </a>

                                <!-- Comment Content -->
                                <div>
                                    <a href="{{ route('profile.show', $latestComment->user->id) }}"
                                        class="text-blue-400 hover:underline"><strong>{{ $latestComment->user->name }}</strong></a>
                                    •
                                    {{ $latestComment->created_at->diffForHumans() }}
                                    <p class="text-gray-200 mt-1">{{ Str::limit($latestComment->content, 100) }}</p>
                                </div>
                            </div>

                            <!-- View All Comments Button -->
                            <div class="mt-2">
                                <a href="{{ route('posts.comments', $post->id) }}"
                                    class="text-blue-400 hover:text-blue-300 transition duration-200">
                                    View all comments ({{ $post->comments->count() }})
                                </a>
                            </div>
                        @endif

                        <!-- Actions (View, Edit, Delete, Share) -->
                        <div class="mt-4">
                            <a href="{{ route('posts.show', $post) }}"
                                class="text-blue-400 hover:text-blue-300 transition duration-200">View</a>
                            @if ($post->user_id === Auth::id())
                                <a href="{{ route('posts.edit', $post) }}"
                                    class="text-yellow-400 hover:text-yellow-300 ml-4 transition duration-200">Edit</a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-400 hover:text-red-300 ml-4 transition duration-200">Delete</button>
                                </form>
                            @endif
                            <!-- Share Button -->
                            <button onclick="openShareModal({{ $post->id }})"
                                class="text-green-400 hover:text-green-300 ml-4 transition duration-200">
                                Share
                            </button>
                        </div>

                        <!-- Shared Post Section -->
                        @if ($post->shared_post_id)
                            <div class="mt-4 bg-gray-700 p-4 rounded-lg">
                                <!-- Shared By -->
                                <div class="flex items-center mb-2">
                                    <a href="{{ route('profile.show', $post->user->id) }}">
                                        @if ($post->user->profile_photo)
                                            <img src="{{ asset('storage/' . $post->user->profile_photo) }}"
                                                alt="{{ $post->user->name }}"
                                                class="w-8 h-8 rounded-full object-cover mr-2">
                                        @else
                                            <div
                                                class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center text-gray-300 text-sm mr-2">
                                                {{ substr($post->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </a>
                                    <p class="text-gray-300">
                                        <a href="{{ route('profile.show', $post->user->id) }}"
                                            class="text-blue-400 hover:underline">{{ $post->user->name }}</a>
                                        shared a post.
                                    </p>
                                </div>

                                <!-- Original Post -->
                                <div class="bg-gray-800 p-4 rounded-lg">
                                    <!-- Original Post Author -->
                                    <div class="flex items-center mb-2">
                                        <a href="{{ route('profile.show', $post->sharedPost->user->id) }}">
                                            @if ($post->sharedPost->user->profile_photo)
                                                <img src="{{ asset('storage/' . $post->sharedPost->user->profile_photo) }}"
                                                    alt="{{ $post->sharedPost->user->name }}"
                                                    class="w-8 h-8 rounded-full object-cover mr-2">
                                            @else
                                                <div
                                                    class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center text-gray-300 text-sm mr-2">
                                                    {{ substr($post->sharedPost->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </a>
                                        <p class="text-gray-300">
                                            <a href="{{ route('profile.show', $post->sharedPost->user->id) }}"
                                                class="text-blue-400 hover:underline">{{ $post->sharedPost->user->name }}</a>
                                            •
                                            {{ $post->sharedPost->created_at->diffForHumans() }}
                                        </p>
                                    </div>

                                    <!-- Original Post Content -->
                                    <h3 class="text-xl font-semibold">{{ $post->sharedPost->title }}</h3>
                                    <p class="text-gray-200">{{ $post->sharedPost->content }}</p>

                                    <!-- Original Post Image -->
                                    @if ($post->sharedPost->post_photo)
                                        <img src="{{ asset('storage/' . $post->sharedPost->post_photo) }}"
                                            alt="Original Post Image"
                                            class="w-full h-64 object-cover rounded-lg mt-2">
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </main>
    </div>

    <!-- Share Post Modal -->
    <div id="shareModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-xl font-semibold mb-4">Share Post</h2>
                <form id="shareForm" method="POST" action="{{ route('posts.share') }}">
                    @csrf
                    <input type="hidden" name="post_id" id="sharedPostId">
                    <textarea name="content" rows="3" class="w-full p-2 bg-gray-700 text-gray-100 rounded"
                        placeholder="Add a message (optional)"></textarea>
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" onclick="closeShareModal()"
                            class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Cancel</button>
                        <button type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Share</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script for Dropdown Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownButton = document.querySelector('header button');
            const dropdownMenu = document.querySelector('header .relative .hidden');

            dropdownButton.addEventListener('click', function() {
                dropdownMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        });

        // AJAX for liking posts
        function likePost(event, postId) {
            event.preventDefault();

            fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById(`like-count-${postId}`).innerText = data.likes_count;
                    document.getElementById(`dislike-count-${postId}`).innerText = data.dislikes_count;
                })
                .catch(error => console.error('Error:', error));
        }

        // AJAX for disliking posts
        function dislikePost(event, postId) {
            event.preventDefault();

            fetch(`/posts/${postId}/dislike`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById(`like-count-${postId}`).innerText = data.likes_count;
                    document.getElementById(`dislike-count-${postId}`).innerText = data.dislikes_count;
                })
                .catch(error => console.error('Error:', error));
        }

        // Function to open the share modal
        function openShareModal(postId) {
            document.getElementById('sharedPostId').value = postId;
            document.getElementById('shareModal').classList.remove('hidden');
        }

        // Function to close the share modal
        function closeShareModal() {
            document.getElementById('shareModal').classList.add('hidden');
        }

        // Handle form submission for sharing a post
        document.getElementById('shareForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeShareModal();
                        window.location.reload(); // Reload the page to show the shared post
                    } else {
                        alert('Failed to share the post.');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>
