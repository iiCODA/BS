<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel Blog') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <!-- Background Gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-500 opacity-10"></div>

        <!-- Header -->
        <header class="relative z-10 text-center mb-12">
            <h1 class="text-5xl font-bold text-gray-100">Welcome to My Blog</h1>
            <p class="mt-4 text-xl text-gray-300">A place to share your thoughts and ideas.</p>
        </header>

        <!-- Main Content -->
        <main class="relative z-10 w-full max-w-4xl px-4">
            <div class="bg-gray-800 shadow-2xl rounded-lg p-8">
                <h2 class="text-3xl font-semibold text-gray-100">Featured Posts</h2>
                <div class="mt-6 space-y-6">
                    @foreach ($posts as $post)
                        <div class="bg-gray-700 p-6 rounded-lg hover:shadow-md transition-shadow">
                            <h3 class="text-2xl font-medium text-gray-100">{{ $post->title }}</h3>
                            <p class="mt-2 text-gray-300">{{ Str::limit($post->content, 150) }}</p>
                            <a href="{{ route('posts.show', $post) }}"
                                class="mt-4 inline-block text-blue-400 hover:text-blue-300">Read More →</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

        <!-- Auth Buttons -->
        <div class="relative z-10 mt-8">
            @if (Route::has('login'))
                <nav class="flex items-center justify-center space-x-4">
                    @auth
                        <a href="{{ url('/posts') }}"
                            class="rounded-md px-4 py-2 text-gray-100 ring-1 ring-gray-600 transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Deep In!
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="rounded-md px-4 py-2 text-gray-100 ring-1 ring-gray-600 transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="rounded-md px-4 py-2 text-white bg-blue-600 transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-4 flex justify-center space-x-4">
            <a href="#" class="text-gray-400 hover:text-blue-400">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-blue-400">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                </svg>
            </a>
        </div>
    </div>
</body>

</html>
