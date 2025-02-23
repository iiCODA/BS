<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - BloGing</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-900 text-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gray-800 shadow-md p-4">
            <div class="container mx-auto flex justify-between items-center">
                <a href="{{ route('posts.index') }}">
                    <h1 class="text-2xl font-bold">BloGing</h1>
                </a>


                <!-- Search Form -->
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
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto p-6">
            <h1 class="text-3xl font-bold mb-6 text-gray-100">Search Results for "{{ $query }}"</h1>

            <!-- Posts Section -->
            @if ($type == 'posts' && isset($posts))
                <div class="space-y-6">
                    @foreach ($posts as $post)
                        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                            <!-- Publisher Info -->
                            <div class="flex items-center mb-4">
                                <a href="{{ route('profile.show', $post->user->id) }}">
                                    @if ($post->user->profile_photo)
                                        <img src="{{ asset('storage/' . $post->user->profile_photo) }}"
                                            alt="{{ $post->user->name }}"
                                            class="w-10 h-10 rounded-full object-cover mr-3">
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
                                    <p class="text-sm text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Post Title -->
                            <h2 class="text-2xl font-semibold mb-2">{{ $post->title }}</h2>
                            <p class="text-gray-300">{{ Str::limit($post->content, 200) }}</p>

                            <!-- Post Image -->
                            @if ($post->post_photo)
                                <img src="{{ asset('storage/' . $post->post_photo) }}" alt="Post Image"
                                    class="w-full h-64 object-cover rounded-lg mb-4">
                            @endif

                            <!-- Like/Dislike buttons -->
                            <div class="mt-4 flex space-x-4">
                                <button type="button" class="flex items-center text-blue-500"
                                    onclick="likePost(event, {{ $post->id }})">
                                    👍 Like (<span
                                        id="like-count-{{ $post->id }}">{{ $post->likes->where('type', 'like')->count() }}</span>)
                                </button>
                                <button type="button" class="flex items-center text-red-500"
                                    onclick="dislikePost(event, {{ $post->id }})">
                                    👎 Dislike (<span
                                        id="dislike-count-{{ $post->id }}">{{ $post->likes->where('type', 'dislike')->count() }}</span>)
                                </button>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="text-blue-400 hover:text-blue-300">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-center mt-6">
                    {{ $posts->appends(['query' => request('query'), 'type' => request('type')])->links() }}
                </div>
            @endif

            <!-- Users Section -->
            @if ($type == 'users' && isset($users))
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-200 mb-4">Users</h2>
                    @foreach ($users as $user)
                        <div class="bg-gray-800 p-6 rounded-lg shadow-lg flex items-center">
                            <!-- User Profile Photo -->
                            <a href="{{ route('profile.show', $user->id) }}">
                                @if ($user->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                        alt="{{ $user->name }}" class="w-12 h-12 rounded-full object-cover mr-4">
                                @else
                                    <div
                                        class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-gray-300 text-lg">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </a>

                            <!-- User Name and Joining Date -->
                            <div>
                                <a href="{{ route('profile.show', $user->id) }}"
                                    class="text-blue-400 hover:underline text-lg font-semibold">
                                    {{ $user->name }}
                                </a>
                                <p class="text-gray-400 text-sm">Joined on {{ $user->created_at->format('F j, Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-center mt-6">
                    {{ $users->appends(['query' => request('query'), 'type' => request('type')])->links() }}
                </div>
            @endif


            <!-- No Results Message -->
            @if (($type == 'posts' && $posts->isEmpty()) || ($type == 'users' && $users->isEmpty()))
                <p class="text-gray-400">No results found.</p>
            @endif
        </main>
    </div>

    <!-- JavaScript for Likes -->
    <script>
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
                });
        }

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
                });
        }
    </script>
</body>

</html>
