<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">{{ $post->title }}</h1>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-700">{{ $post->content }}</p>
            <div class="mt-4">
                <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 hover:underline">Edit</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline ml-4">Delete</button>
                </form>
            </div>
        </div>
        <a href="{{ route('posts.index') }}" class="inline-block mt-6 text-blue-500 hover:underline">Back to Posts</a>
    </div>
</body>

</html>
