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
        <!-- Back Button -->
        <a href="{{ route('posts.index') }}" class="inline-block mb-6 text-blue-500 hover:underline">Back to Posts</a>

        <!-- Post Container -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <!-- Publisher Info -->
            <div class="flex items-center mb-6">
                <!-- Profile Photo -->
                @if ($post->user->profile_photo)
                    <img src="{{ asset('storage/' . $post->user->profile_photo) }}" alt="{{ $post->user->name }}"
                        class="w-10 h-10 rounded-full object-cover mr-3">
                @else
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                        <span class="text-gray-600 text-sm">{{ substr($post->user->name, 0, 1) }}</span>
                    </div>
                @endif

                <!-- Publisher Name and Timestamp -->
                <div>
                    <p class="font-semibold text-gray-800">{{ $post->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Post Title -->
            <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

            <!-- Post Content -->
            <p class="text-gray-700">{{ $post->content }}</p>

            <!-- Edit/Delete Buttons (for the post owner) -->
            <div class="mt-6">
                @if ($post->user_id === Auth::id())
                    <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 hover:underline">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline ml-4">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
