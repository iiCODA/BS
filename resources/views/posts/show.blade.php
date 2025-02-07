<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100">
    <div class="container mx-auto p-4">
        <!-- Back Button -->
        <a href="{{ route('posts.index') }}"
            class="inline-block mb-6 text-blue-400 hover:text-blue-300 transition duration-200">
            Back to Posts
        </a>

        <!-- Post Container -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <!-- Publisher Info -->
            <div class="flex items-center mb-6">
                <!-- Profile Photo -->
                @if ($post->user->profile_photo)
                    <img src="{{ asset('storage/' . $post->user->profile_photo) }}" alt="{{ $post->user->name }}"
                        class="w-10 h-10 rounded-full object-cover mr-3">
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
            <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

            <!-- Post Content -->
            <p class="text-gray-300 break-words whitespace-pre-wrap">{{ $post->content }}</p>


            <!-- Post Image -->
            @if ($post->post_photo)
                <img src="{{ asset('storage/' . $post->post_photo) }}" alt="Post Image"
                    class="w-full max-h-[500px] object-contain rounded-lg mb-4">
            @endif

            <!-- Edit/Delete Buttons (for the post owner) -->
            <div class="mt-6">
                @if ($post->user_id === Auth::id())
                    <a href="{{ route('posts.edit', $post) }}"
                        class="text-yellow-400 hover:text-yellow-300 transition duration-200">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-red-400 hover:text-red-300 ml-4 transition duration-200">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
