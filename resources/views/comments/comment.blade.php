<style>
    .comment-content {
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        white-space: normal !important;
        max-width: 100% !important;
        overflow-x: auto !important;
    }
</style>

<div class="bg-gray-800 p-3 rounded-lg mb-2">
    <div class="flex items-start">
        <!-- Profile Photo -->
        <a href="{{ route('profile.show', $comment->user->id) }}" class="flex items-center">
            @if ($comment->user->profile_photo)
                <img src="{{ asset('storage/' . $comment->user->profile_photo) }}" alt="{{ $comment->user->name }}"
                    class="w-10 h-10 rounded-full object-cover mr-3">
            @else
                <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-gray-300 text-sm">
                    {{ substr($comment->user->name, 0, 1) }}
                </div>
            @endif
        </a>

        <div class="flex-1">
            <p class="text-sm text-gray-300">
                <a href="{{ route('profile.show', $comment->user->id) }}" class="font-semibold hover:text-blue-400">
                    {{ $comment->user->name }}
                </a>
                • {{ $comment->created_at->diffForHumans() }}
            </p>

            <p class="text-gray-200 mt-1 comment-content">
                {{ $comment->content }}
            </p>

            <!-- Like/Dislike Buttons -->
            <div class="flex items-center space-x-4 mt-2">
                <!-- Like Button -->
                <button type="button" class="flex items-center text-blue-500"
                    onclick="likeComment(event, {{ $comment->post_id }}, {{ $comment->id }})">
                    <!-- Thumbs Up Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 9l2-2m0 0l-2-2m2 2H5m9 7h3a4 4 0 004-4V7a4 4 0 00-4-4h-1a2 2 0 00-1.732.986L10 5l-1-2-2 4V15a4 4 0 004 4h1z" />
                    </svg>
                    Like (<span
                        id="like-count-comment-{{ $comment->id }}">{{ $comment->likes->where('type', 'like')->count() }}</span>)
                </button>

                <!-- Dislike Button -->
                <button type="button" class="flex items-center text-red-500"
                    onclick="dislikeComment(event, {{ $comment->post_id }}, {{ $comment->id }})">
                    <!-- Thumbs Down Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 15l-2 2m0 0l2 2m-2-2H5m9-7h3a4 4 0 004-4V7a4 4 0 00-4-4h-1a2 2 0 00-1.732.986L10 5l-1-2-2 4V15a4 4 0 004 4h1z" />
                    </svg>
                    Dislike (<span
                        id="dislike-count-comment-{{ $comment->id }}">{{ $comment->likes->where('type', 'dislike')->count() }}</span>)
                </button>
            </div>

            <!-- Reply Button -->
            <button class="text-blue-400 text-sm mt-2" onclick="toggleReplyForm({{ $comment->id }})">
                Reply
            </button>

            <!-- Reply Form -->
            <form action="{{ route('comments.store', $comment->post_id) }}" method="POST"
                class="mt-2 hidden reply-form-{{ $comment->id }}">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea name="content" rows="2" class="w-full p-2 bg-gray-700 text-gray-100 rounded"
                    placeholder="Write a reply..." required></textarea>
                <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded">
                    Reply
                </button>
            </form>

            <!-- Nested Replies -->
            @if ($comment->replies->count() > 0)
                <div class="ml-10 mt-3 border-l-2 border-gray-500 pl-4">
                    @foreach ($comment->replies as $reply)
                        @include('comments.comment', ['comment' => $reply])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>