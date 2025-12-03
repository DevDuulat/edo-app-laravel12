<div class="flex-1 overflow-y-auto flex flex-col gap-6 p-6" id="commentsContainer">
    @foreach($workflow->comments()->oldest()->get() as $comment)
        @php
            $isOwn = $comment->user_id === auth()->id();
            $colors = ['red','orange','amber','yellow','lime','green','emerald','teal','cyan','sky','blue','indigo','violet','purple','fuchsia','pink','rose'];
            $colorIndex = crc32($comment->user->name) % count($colors);
            $color = $colors[$colorIndex];
        @endphp

        <div class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }} gap-3 max-w-full group">
            @unless($isOwn)
                <flux:avatar name="{{ $comment->user->name }}" color="{{ $color }}" size="9" class="self-end shrink-0" />
            @endunless

            <div class="flex flex-col relative leading-snug {{ $isOwn ? 'items-end' : 'items-start' }}">
                <div class="flex flex-col px-4 py-3 shadow-sm max-w-xs sm:max-w-md lg:max-w-lg
                                {{ $isOwn
                                    ? 'bg-blue-100 text-gray-900 rounded-2xl rounded-br-none'
                                    : 'bg-gray-100 border border-gray-200 text-gray-900 rounded-2xl rounded-bl-none'
                                }}">
                    <div class="flex items-center gap-2 mb-1 text-sm {{ $isOwn ? 'justify-end' : 'justify-start' }}">
                        <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                        <span class="text-xs text-gray-500">{{ $comment->created_at->format('H:i d.m.Y') }}</span>
                    </div>
                    <p class="text-sm leading-relaxed whitespace-pre-wrap break-words">{{ $comment->comment }}</p>
                </div>
            </div>

            @if($isOwn)
                <flux:avatar name="{{ $comment->user->name }}" color="{{ $color }}" size="9" class="self-end shrink-0" />
            @endif
        </div>
    @endforeach
</div>

<form
        method="POST"
        action="{{ route('admin.workflows.comment.store', $workflow->id) }}"
        @submit="scrollToBottom()"
        class="flex items-center gap-3 border-t border-gray-200 p-4"
>
    @csrf
    <textarea
            id="comment"
            name="comment"
            rows="1"
            class="flex-1 p-2 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none"
            placeholder="Введите комментарий..."
    ></textarea>
    <button type="submit" class="p-2 text-blue-600 rounded-full hover:bg-blue-100" title="Отправить">
        <svg class="w-5 h-5 rotate-90" fill="currentColor" viewBox="0 0 18 20">
            <path d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z"/>
        </svg>
    </button>
</form>