<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100">
    <div class="container mx-auto p-6">
        <!-- Back Button -->
        <a href="{{ route('posts.index') }}"
            class="inline-block mb-6 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
            Back to Posts
        </a>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6">Create New Post</h1>

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-gray-300 font-semibold mb-2">Title</label>
                    <input type="text" name="title" id="title"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-gray-300 font-semibold mb-2">Content</label>
                    <textarea name="content" id="content" rows="6"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required></textarea>
                </div>

                <div class="mb-4">
                    <label for="post_photo" class="block text-gray-300 font-semibold mb-2">Post Photo</label>
                    <input type="file" name="post_photo" id="post_photo"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                    Create Post
                </button>
            </form>
        </div>
    </div>
</body>

</html>
