@extends('common.layout')
@section('content')

<style>
    /* ── Blog content typography ── */
    .blog-content h1, .blog-content h2, .blog-content h3,
    .blog-content h4, .blog-content h5, .blog-content h6 {
        color: #ffffff !important; margin-top: 2.2rem; margin-bottom: 1rem; font-weight: 700; letter-spacing: -0.02em;
    }
    .blog-content h1 { font-size: 2.2rem; }
    .blog-content h2 { font-size: 1.7rem; }
    .blog-content h3 { font-size: 1.3rem; }
    .blog-content p { margin-bottom: 1.6rem; line-height: 1.85; color: #9ca3af; }
    .blog-content img { max-width: 100%; height: auto; border-radius: 12px; margin: 2rem 0; border: 1px solid #1a1a1a; }
    .blog-content blockquote {
        border-left: 3px solid #B1E78E;
        padding: 16px 20px; margin: 2rem 0;
        font-style: italic;
        background: rgba(177,231,142,0.05);
        border-radius: 0 10px 10px 0;
        color: #b0b8c4;
    }
    .blog-content ul, .blog-content ol { margin: 1.5rem 0; padding-left: 1.5rem; }
    .blog-content li { margin-bottom: 0.55rem; color: #9ca3af; line-height: 1.7; }
    .blog-content a { color: #B1E78E !important; text-decoration: none; border-bottom: 1px solid rgba(177,231,142,0.3); transition: border-color .2s; }
    .blog-content a:hover { border-color: #B1E78E; }
    .blog-content a:visited { color: rgba(177,231,142,0.75) !important; }
    .blog-content strong { color: #e5e7eb; }
    .blog-content code {
        background: rgba(177,231,142,0.08); color: #B1E78E;
        padding: 2px 7px; border-radius: 5px; font-size: .88em;
        border: 1px solid rgba(177,231,142,0.15);
    }
    .blog-content pre { background: #0a0a0a; border: 1px solid #1a1a1a; border-radius: 12px; padding: 20px; overflow-x: auto; margin: 1.5rem 0; }
    .blog-content pre code { background: none; border: none; padding: 0; color: #B1E78E; }

    /* ── Chapter separator ── */
    .chapter-sep {
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, rgba(177,231,142,0.10) 35%, rgba(177,231,142,0.10) 65%, transparent 100%);
    }
    .chapter-label {
        font-size: 0.62rem; font-weight: 700; letter-spacing: 0.22em;
        text-transform: uppercase; color: rgba(177,231,142,0.4);
        display: block; margin-bottom: 8px;
    }

    /* ── Tag pills ── */
    .blog-tag {
        display: inline-flex; align-items: center;
        background: rgba(177,231,142,0.07); border: 1px solid rgba(177,231,142,0.18);
        color: #B1E78E; padding: 4px 13px; border-radius: 100px;
        font-size: 0.73rem; font-weight: 600; text-decoration: none;
        transition: background .2s, border-color .2s;
    }
    .blog-tag:hover { background: rgba(177,231,142,0.14); border-color: rgba(177,231,142,0.35); }

    /* ── Related article cards ── */
    .related-card {
        background: #0a0a0a; border: 1px solid #1a1a1a; border-radius: 16px;
        overflow: hidden; cursor: pointer;
        transition: border-color .25s, transform .22s;
    }
    .related-card:hover { border-color: rgba(177,231,142,0.22); transform: translateY(-3px); }

    /* ── Dark form inputs ── */
    .dark-input {
        width: 100%; background: #0d0d0d; border: 1px solid #222;
        border-radius: 10px; padding: 12px 16px; color: #fff;
        font-size: .9rem; outline: none; transition: border-color .2s;
    }
    .dark-input:focus { border-color: rgba(177,231,142,0.45); }
    .dark-input::placeholder { color: #4b5563; }

    /* ── Comment cards ── */
    .comment-card { background: #0a0a0a; border: 1px solid #1a1a1a; border-radius: 14px; padding: 20px; }

    /* ── Breadcrumb ── */
    .breadcrumb-link { color: #6b7280; text-decoration: none; font-size: .85rem; transition: color .2s; }
    .breadcrumb-link:hover { color: #B1E78E; }
</style>

<div id="blogDetail">

    <!-- ── Blog Header ── -->
    <section style="padding:80px 0 48px;background:#060606;">
        <div class="max-w-4xl mx-auto px-6">

            <!-- Breadcrumbs -->
            <nav class="mb-8">
                <div class="flex items-center gap-2 flex-wrap" style="font-size:.82rem;color:#4b5563;">
                    <a href="{{ route('blog') }}" class="breadcrumb-link">Blog</a>
                    <i class="fas fa-chevron-right" style="font-size:.6rem;"></i>
                    <a href="{{ route('blog') }}?category={{ $post->category->slug }}" class="breadcrumb-link">{{ $post->category->name }}</a>
                    <i class="fas fa-chevron-right" style="font-size:.6rem;"></i>
                    <span class="text-gray-400">{{ Str::limit($post->title, 55) }}</span>
                </div>
            </nav>

            <!-- Category + Meta -->
            <div class="flex flex-wrap items-center gap-3 mb-6">
                <span class="proof-badge" style="font-size:.72rem;">
                    {{ $post->category->name }}
                </span>
                <span style="color:#374151;font-size:.8rem;">{{ $post->reading_time_text }}</span>
                <span style="color:#1f2937;">·</span>
                <span style="color:#374151;font-size:.8rem;">{{ $post->published_at->format('M j, Y') }}</span>
                @if($post->updated_at > $post->published_at)
                    <span style="color:#1f2937;">·</span>
                    <span style="color:#374151;font-size:.8rem;">Updated {{ $post->updated_at->format('M j, Y') }}</span>
                @endif
            </div>

            <!-- Title -->
            <h1 class="text-white font-black leading-tight mb-5" style="font-size:clamp(2rem,4.5vw,3rem);letter-spacing:-0.03em;">
                {{ $post->title }}
            </h1>

            <!-- Excerpt -->
            <p style="font-size:1.05rem;line-height:1.78;color:#9ca3af;margin-bottom:32px;">
                {{ $post->excerpt }}
            </p>

            <!-- Author + Views -->
            <div class="flex items-center justify-between border-t pt-6" style="border-color:#141414;">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('public/assets/'.$post->author->profile_image) }}"
                         alt="{{ $post->author->first_name.' '.$post->author->last_name }}"
                         class="rounded-full object-cover"
                         style="width:44px;height:44px;border:2px solid rgba(177,231,142,0.3);">
                    <div>
                        <div class="text-white font-semibold" style="font-size:.9rem;">{{ $post->author->first_name.' '.$post->author->last_name }}</div>
                        <div style="color:#6b7280;font-size:.75rem;">{{ $post->author->title ?? 'Author' }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2" style="color:#4b5563;font-size:.82rem;">
                    <i class="fas fa-eye"></i>
                    <span>{{ number_format($post->views_count) }} views</span>
                </div>
            </div>

        </div>
    </section>

    <div class="chapter-sep"></div>

    <!-- ── Featured Image ── -->
    <section style="padding:40px 0;background:#000;">
        <div class="max-w-4xl mx-auto px-6">
            <div class="rounded-2xl overflow-hidden" style="border:1px solid #1a1a1a;background:#0a0a0a;">
                <img src="{{ asset('public/' . $post->featured_image) }}"
                     alt="{{ $post->title }}"
                     class="w-full"
                     style="max-height:420px;object-fit:contain;display:block;">
            </div>
        </div>
    </section>

    <!-- ── Article Content ── -->
    <section style="padding:40px 0 60px;background:#000;">
        <div class="max-w-4xl mx-auto px-6">
            <div class="blog-content">
                {!! $post->content !!}
            </div>

            <!-- Tags -->
            @if($post->tags->count() > 0)
            <div class="mt-12 pt-8 border-t" style="border-color:#141414;">
                <p style="font-size:.62rem;font-weight:700;letter-spacing:.20em;text-transform:uppercase;color:rgba(177,231,142,0.4);margin-bottom:12px;">Tags</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                    <a href="{{ route('blog') }}?search={{ $tag->name }}" class="blog-tag">#{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- ── Related Articles ── -->
    @if($relatedPosts->count() > 0)
    <div class="chapter-sep"></div>
    <section style="padding:72px 0;background:#060606;">
        <div class="max-w-6xl mx-auto px-6">
            <span class="chapter-label">Continue Reading</span>
            <h3 class="text-white font-black mb-8" style="font-size:1.8rem;letter-spacing:-0.02em;">Related Articles</h3>
            <div class="grid gap-6
                @if($relatedPosts->count() == 1) md:grid-cols-1
                @elseif($relatedPosts->count() == 2) md:grid-cols-2
                @else md:grid-cols-3
                @endif">
                @foreach($relatedPosts as $related)
                <article class="related-card" onclick="window.location.href='{{ route('blog.details', $related->slug) }}'">
                    <img src="{{ asset('public/' . $related->featured_image) }}"
                         alt="{{ $related->title }}"
                         class="w-full object-cover" style="height:180px;">
                    <div class="p-6">
                        <span class="proof-badge mb-3 inline-flex" style="font-size:.68rem;">
                            {{ $related->category->name }}
                        </span>
                        <h4 class="text-white font-bold mt-3 mb-2 leading-snug" style="font-size:.95rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $related->title }}
                        </h4>
                        <p style="color:#6b7280;font-size:.82rem;line-height:1.6;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $related->excerpt }}
                        </p>
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center gap-2" style="font-size:.78rem;color:#6b7280;">
                                <img src="{{ asset('public/assets/'.$related->author->profile_image) }}"
                                     alt="{{ $related->author->first_name }}"
                                     class="rounded-full object-cover" style="width:20px;height:20px;">
                                <span>{{ $related->author->first_name.' '.$related->author->last_name }}</span>
                            </div>
                            <span style="font-size:.75rem;color:#4b5563;">{{ $related->reading_time_text }}</span>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ── Comments ── -->
    @if($post->allow_comments)
    <div class="chapter-sep"></div>
    <section style="padding:72px 0;background:#000;">
        <div class="max-w-4xl mx-auto px-6">

            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="chapter-label">Discussion</span>
                    <h3 class="text-white font-black" style="font-size:1.6rem;letter-spacing:-0.02em;">
                        Comments ({{ $post->comments_count }})
                    </h3>
                </div>
                <button onclick="toggleComments()"
                        style="color:#6b7280;background:none;border:none;cursor:pointer;font-size:.85rem;display:flex;align-items:center;gap:6px;transition:color .2s;"
                        onmouseover="this.style.color='#B1E78E'" onmouseout="this.style.color='#6b7280'">
                    <i class="fas fa-comments"></i> Join Discussion
                </button>
            </div>

            <!-- Comment Form -->
            <div id="commentForm" class="comment-card mb-8">
                <h4 class="text-white font-bold mb-5" style="font-size:1rem;">Leave a Comment</h4>
                <form id="commentSubmitForm" onsubmit="submitComment(event)">
                    @csrf
                    <input type="hidden" name="blog_post_id" value="{{ $post->id }}">
                    <div class="grid md:grid-cols-2 gap-3 mb-3">
                        <input type="text" name="author_name" placeholder="Your Name" required class="dark-input">
                        <input type="email" name="author_email" placeholder="Your Email" required class="dark-input">
                    </div>
                    <textarea rows="4" name="content" placeholder="Your Comment" required class="dark-input mb-4" style="resize:vertical;"></textarea>
                    <button type="submit" class="btn-brand" style="padding:12px 24px;font-size:.9rem;">
                        <i class="fas fa-paper-plane"></i> Post Comment
                    </button>
                </form>
            </div>

            <!-- Comments List -->
            <div id="commentsList" class="space-y-4">
                @forelse($post->approvedComments as $comment)
                <div class="comment-card">
                    <div class="flex items-start gap-4">
                        <img src="{{ $comment->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->author_name ?? $comment->author->name) . '&background=0d0d0d&color=B1E78E&size=50' }}"
                             alt="{{ $comment->author_name ?? $comment->author->name }}"
                             class="rounded-full object-cover flex-shrink-0" style="width:44px;height:44px;border:1px solid #1a1a1a;">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <h5 class="text-white font-semibold" style="font-size:.9rem;">{{ $comment->author_name ?? $comment->author->name }}</h5>
                                    <span style="color:#4b5563;font-size:.75rem;">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                @if($comment->author_id === auth()->id())
                                <button onclick="deleteComment({{ $comment->id }})"
                                        style="color:#ef4444;background:none;border:none;cursor:pointer;font-size:.8rem;opacity:.7;transition:opacity .2s;"
                                        onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='.7'">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                            <p style="color:#9ca3af;font-size:.875rem;line-height:1.65;">{{ $comment->content }}</p>
                            <button onclick="replyToComment({{ $comment->id }})"
                                    style="color:#4b5563;background:none;border:none;cursor:pointer;font-size:.78rem;margin-top:8px;display:flex;align-items:center;gap:5px;transition:color .2s;"
                                    onmouseover="this.style.color='#B1E78E'" onmouseout="this.style.color='#4b5563'">
                                <i class="fas fa-reply"></i> Reply
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <i class="fas fa-comments" style="font-size:2.5rem;color:#1f2937;margin-bottom:12px;display:block;"></i>
                    <p style="color:#4b5563;font-size:.9rem;">No comments yet. Be the first to share your thoughts!</p>
                </div>
                @endforelse
            </div>

            @if($post->approvedComments->count() >= 10)
            <div class="text-center mt-8">
                <button onclick="loadMoreComments()"
                        style="color:#6b7280;background:none;border:none;cursor:pointer;font-size:.85rem;transition:color .2s;"
                        onmouseover="this.style.color='#B1E78E'" onmouseout="this.style.color='#6b7280'">
                    Load More Comments
                </button>
            </div>
            @endif

        </div>
    </section>
    @endif

    <!-- ── Newsletter ── -->
    <div class="chapter-sep"></div>
    <section style="padding:72px 0;background:#060606;">
        <div class="max-w-4xl mx-auto px-6">
            <div class="rounded-2xl p-8 text-center glow-green" style="background:#0a0a0a;border:1px solid rgba(177,231,142,0.18);">
                <span class="chapter-label" style="text-align:center;">Stay Updated</span>
                <h3 class="text-white font-black mb-3" style="font-size:1.7rem;letter-spacing:-0.02em;">Enjoyed this article?</h3>
                <p style="color:#6b7280;font-size:.9rem;margin-bottom:24px;max-width:380px;margin-left:auto;margin-right:auto;line-height:1.7;">
                    Subscribe to get notified when new articles are published. No spam, unsubscribe anytime.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    <input type="email" id="newsletterEmail" placeholder="Enter your email"
                           class="dark-input" style="flex:1;">
                    <button onclick="subscribeNewsletter()" class="btn-brand" style="padding:12px 22px;font-size:.9rem;white-space:nowrap;">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
