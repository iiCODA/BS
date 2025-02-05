<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Blog Posts</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Create New Post</a>

        @foreach ($posts as $post)
        <div class="bg-white p-6 rounded-lg shadow-md mb-4">
            <h2 class="text-2xl font-semibold">{{ $post->title }}</h2>
            <p class="text-gray-700 mt-2">{{ Str::limit($post->content, 200) }}</p>
            <div class="mt-4">
                <a href="{{ route('posts.show', $post) }}" class="text-blue-500 hover:underline">View</a>
                <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 hover:underline ml-4">Edit</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline ml-4">Delete</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</body>

</html>