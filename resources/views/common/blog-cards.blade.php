@foreach($blogs as $blog)
<article class="rounded-xl overflow-hidden card-hover cursor-pointer" style="background:#0d0d0d;border:1px solid #222222;"
         onclick="window.location.href='{{ route('blog.details', $blog->slug) }}'">
    <img src="{{ asset('public/' . $blog->featured_image) }}"
         alt="{{ $blog->title }}"
         class="w-full h-36 object-cover"
         loading="lazy">
    <div class="p-4">
        <div class="flex items-center mb-2">
            <span class="bg-{{ $blog->category->color ?? 'blue' }}-600 text-white px-2 py-0.5 rounded-full text-xs font-medium">
                {{ $blog->category->name }}
            </span>
            <span class="text-gray-400 ml-2 text-xs">{{ $blog->reading_time_text }}</span>
        </div>
        <h3 class="text-base font-bold mb-2 line-clamp-2">{{ $blog->title }}</h3>
        <p class="text-gray-400 text-sm mb-3 line-clamp-2">{{ $blog->excerpt }}</p>
        <div class="flex items-center justify-between text-xs">
            <div class="flex items-center gap-2">
                <img src="{{ asset('public/assets/'.$blog->author->profile_image) }}"
                     alt="{{ $blog->author->first_name.' '.$blog->author->last_name }}"
                     class="w-5 h-5 rounded-full">
                <div>
                    <span class="text-gray-300">{{ $blog->author->first_name.' '.$blog->author->last_name }}</span>
                    <span class="text-gray-500 mx-1">•</span>
                    <span class="text-gray-400">{{ $blog->published_date }}</span>
                </div>
            </div>
            <div class="flex items-center text-gray-400 gap-1">
                <i class="fas fa-eye"></i>
                <span>{{ number_format($blog->views_count) }}</span>
            </div>
        </div>
    </div>
</article>
@endforeach
