<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Sidebar and Main Content Wrapper -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div
            class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out">
            <!-- Logo -->
            <div class="text-white flex items-center space-x-2 px-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
                <span class="text-2xl font-extrabold">Blog</span>
            </div>

            <!-- Navigation Links -->
            <nav>

                <a href="{{ route('posts.create') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                    Create Post
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64">
            <!-- Header -->
            <header class="bg-white shadow-md p-4">
                <div class="flex justify-between items-center">
                    <!-- Page Title -->
                    <h1 class="text-2xl font-bold text-gray-800">Blog Posts</h1>

                    <!-- User Dropdown -->
                    <div class="relative">
                        <button class="flex items-center text-gray-800 focus:outline-none">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Log
                                    Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6">
                <!-- Create New Post Button -->
                <a href="{{ route('posts.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                    Create New Post
                </a>

                <!-- Blog Posts List -->
                <div class="space-y-6">
                    @foreach ($posts as $post)
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h2 class="text-2xl font-semibold">{{ $post->title }}</h2>
                            <p class="text-gray-700 mt-2">{{ Str::limit($post->content, 200) }}</p>
                            <div class="mt-4">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="text-blue-500 hover:underline">View</a>
                                <a href="{{ route('posts.edit', $post) }}"
                                    class="text-yellow-500 hover:underline ml-4">Edit</a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-4">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </main>
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
    </script>
</body>

</html>
