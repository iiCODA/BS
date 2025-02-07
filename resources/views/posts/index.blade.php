<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloGing</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100">
    <!-- Main Container -->
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gray-800 shadow-md p-4">
            <div class="container mx-auto flex justify-between items-center">
                <!-- Page Title -->
                <h1 class="text-2xl font-bold">BloGing</h1>

                <!-- User Dropdown -->
                <div class="relative">
                    <button class="flex items-center focus:outline-none">
                        <span class="mr-2">{{ Auth::user()->name }}</span>
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
                            <!-- Profile Photo -->
                            @if ($post->user->profile_photo)
                                <img src="{{ asset('storage/' . $post->user->profile_photo) }}"
                                    alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                            @else
                                <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-gray-300 text-sm">{{ substr($post->user->name, 0, 1) }}</span>
                                </div>
                            @endif

                            <!-- Publisher Name and Timestamp -->
                            <div>
                                <p class="font-semibold">{{ $post->user->name }}</p>
                                <p class="text-sm text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
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


                        <!-- Actions (View, Edit, Delete) -->
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
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
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
    </script>
</body>

</html>
