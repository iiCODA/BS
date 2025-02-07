<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Edit Post</h1>
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ $post->title }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>
            <div class="mb-4">
                <label for="content" class="block text-gray-700 font-semibold mb-2">Content</label>
                <textarea name="content" id="content" rows="6"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $post->content }}</textarea>
            </div>
            <!-- Current Post Photo -->
            @if ($post->post_photo)
                <img src="{{ asset('storage/' . $post->post_photo) }}" alt="Post Image"
                    class="w-full max-h-[500px] object-contain rounded-lg mb-4">
            @endif

            <!-- File Input for New Photo -->
            <div class="mb-4">
                <label for="post_photo" class="block text-gray-700 font-semibold mb-2">Change Post Photo</label>
                <input type="file" name="post_photo" id="post_photo"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Update
                Post</button>
        </form>

        <a href="{{ route('posts.index') }}" class="inline-block mt-6 text-blue-500 hover:underline">Back to Posts</a>
    </div>
</body>

</html>
