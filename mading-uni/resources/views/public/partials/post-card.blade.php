<a href="{{ route('public.posts.show', [$post->university, $post]) }}"
   class="card card-hover group flex flex-col h-full">

    <div class="aspect-video bg-brand-50 relative overflow-hidden">
        @if($post->cover_image_path)
            <img src="{{ $post->cover_url }}"
                 alt="{{ $post->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center bg-brand-gradient text-white">
                <i data-lucide="image" class="w-12 h-12 opacity-60"></i>
            </div>
        @endif

        <span class="absolute top-3 left-3 badge bg-white/95 backdrop-blur text-brand-700 shadow-sm">
            {{ $post->category->name }}
        </span>
    </div>

    <div class="flex-1 p-5 flex flex-col">
        <h3 class="font-bold text-lg mb-2.5 line-clamp-2 group-hover:text-brand-700 transition text-ink">
            {{ $post->title }}
        </h3>

        @if($post->excerpt)
            <p class="text-ink-muted text-sm leading-relaxed mb-4 line-clamp-2">
                {{ $post->excerpt }}
            </p>
        @endif

        <div class="mt-auto pt-4 flex items-center justify-between text-xs text-ink-muted border-t border-surface-border">
            <div class="flex items-center gap-2 min-w-0">
                <div class="w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold text-white"
                     style="background: {{ $post->university->primary_color }};">
                    {{ strtoupper(substr($post->university->name, 0, 1)) }}
                </div>
                <span class="truncate">{{ $post->university->name }}</span>
            </div>
            <span class="flex-shrink-0 flex items-center gap-1">
                <i data-lucide="clock" class="w-3 h-3"></i>
                {{ $post->published_at?->diffForHumans() ?? '-' }}
            </span>
        </div>
    </div>

</a>