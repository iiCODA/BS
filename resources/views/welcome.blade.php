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

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white">Welcome to My Blog</h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">A place to share your thoughts and ideas.</p>
        </header>

        <!-- Main Content -->
        <main class="w-full max-w-4xl px-4">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Featured Posts</h2>
                <div class="mt-4 space-y-4">
                    <!-- Example Post -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-medium text-gray-800 dark:text-white">Post Title</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">This is a brief excerpt from the blog post. It
                            gives a quick overview of what the post is about.</p>
                        <a href="#"
                            class="mt-4 inline-block text-blue-500 hover:text-blue-600 dark:hover:text-blue-400">Read
                            More →</a>
                    </div>

                    <!-- Example Post -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-medium text-gray-800 dark:text-white">Another Post Title</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">This is another brief excerpt from a different
                            blog post. It gives a quick overview of what the post is about.</p>
                        <a href="#"
                            class="mt-4 inline-block text-blue-500 hover:text-blue-600 dark:hover:text-blue-400">Read
                            More →</a>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-8 text-center text-gray-600 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel Blog') }}. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>
