<a href="{{ route('public.universities.show', $university) }}"
   class="card card-hover group p-6 block">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0 w-14 h-14 rounded-2xl overflow-hidden flex items-center justify-center"
             style="background: color-mix(in srgb, {{ $university->primary_color }} 12%, white); color: {{ $university->primary_color }};">
            @if($university->logo_path)
                <img src="{{ $university->logo_url }}" alt="{{ $university->name }}" class="w-full h-full object-contain p-1.5">
            @else
                <i data-lucide="building-2" class="w-7 h-7"></i>
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <h3 class="font-bold mb-1.5 line-clamp-2 group-hover:text-brand-700 transition text-ink">
                {{ $university->name }}
            </h3>
            <div class="flex items-center gap-1 text-xs text-ink-muted mb-3">
                <i data-lucide="map-pin" class="w-3 h-3"></i>
                {{ $university->city ?? 'Indonesia' }}
            </div>
            <span class="badge badge-brand">
                <i data-lucide="file-text" class="w-3 h-3"></i>
                {{ $university->published_posts_count }} konten
            </span>
        </div>
        <i data-lucide="arrow-up-right" class="w-4 h-4 text-ink-soft group-hover:text-brand-700 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition flex-shrink-0"></i>
    </div>
</a>