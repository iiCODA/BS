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
    <p class="text-sm text-gray-300">
        <strong>{{ $comment->user->name }}</strong> • {{ $comment->created_at->diffForHumans() }}
    </p>

    <p class="text-gray-200 mt-1 comment-content">
        {{ $comment->content }}
    </p>



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
