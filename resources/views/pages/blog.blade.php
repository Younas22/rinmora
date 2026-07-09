@extends('common.layout')
@section('content')

    <div id="pageContent">
        <div id="blogListing">

            <!-- Hero Section -->
            <section class="py-10 bg-black pt-20 border-b section-line">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h1 class="text-2xl md:text-3xl font-bold mb-2">
                            Technical <span class="gradient-text">Blog</span>
                        </h1>
                        <p class="text-sm text-gray-400 max-w-2xl mx-auto mb-6">
                            Insights, tutorials, and experiences from my journey as a Laravel developer.
                            Learn about web development, API integration, and modern PHP practices.
                        </p>

                        <!-- Stats -->
                        <div class="flex flex-wrap justify-center gap-6 mt-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold gradient-text">{{ $stats['total_posts'] }}+</div>
                                <div class="text-gray-400 text-xs">Articles</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold gradient-text">{{ number_format($stats['total_views']) }}+</div>
                                <div class="text-gray-400 text-xs">Readers</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold gradient-text">{{ $stats['total_categories'] }}+</div>
                                <div class="text-gray-400 text-xs">Categories</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Filters & Search -->
            <section class="py-5 bg-black border-b border-gray-800">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                        <!-- Search -->
                        <div class="w-full md:w-80">
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Search articles..."
                                       value="{{ request('search') }}"
                                       class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 pl-9 text-white text-sm focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                            </div>
                        </div>

                        <!-- Category Filters -->
                        <div class="flex flex-wrap gap-2" id="categoryFilters">
                            <button class="category-filter {{ !request('category') || request('category') == 'all' ? 'bg-white text-black' : 'bg-gray-800 text-white hover:bg-gray-700' }} px-3 py-1 rounded-full text-xs font-medium transition-colors"
                                    data-category="all">All</button>
                            @foreach($categories as $category)
                            <button class="category-filter {{ request('category') == $category->slug ? 'bg-white text-black' : 'bg-gray-800 text-white hover:bg-gray-700' }} px-3 py-1 rounded-full text-xs font-medium transition-colors"
                                    data-category="{{ $category->slug }}">
                                {{ $category->name }} ({{ $category->posts_count }})
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            @if($featuredPost)
            <!-- Featured Article -->
            <section class="py-10 bg-black border-b section-line">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="mb-5">
                        <h2 class="text-xl font-bold mb-1">Featured Article</h2>
                        <p class="text-gray-400 text-sm">Latest insights and tutorials</p>
                    </div>

                    <div class="rounded-xl overflow-hidden card-hover cursor-pointer" style="background:#111111;border:1px solid #222222;"
                         onclick="window.location.href='{{ route('blog.details', $featuredPost->slug) }}'">
                        <div class="md:flex">
                            <div class="md:w-1/2">
                                <img src="{{ asset('public/' . $featuredPost->featured_image) }}"
                                     alt="{{ $featuredPost->title }}"
                                     class="w-full h-52 md:h-full object-cover">
                            </div>
                            <div class="md:w-1/2 p-5">
                                <div class="flex items-center mb-3">
                                    <span class="bg-{{ $featuredPost->category->color ?? 'red' }}-600 text-white px-2 py-0.5 rounded-full text-xs font-medium">
                                        {{ $featuredPost->category->name }}
                                    </span>
                                    <span class="text-gray-400 ml-3 text-xs">{{ $featuredPost->reading_time_text }}</span>
                                </div>
                                <h3 class="text-lg font-bold mb-2">
                                    <a href="{{ route('blog.details', $featuredPost->slug) }}">{{ $featuredPost->title }}</a>
                                </h3>
                                <p class="text-gray-400 text-sm mb-4">{{ $featuredPost->excerpt }}</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset('public/assets/'.$featuredPost->author->profile_image) }}"
                                             alt="{{ $featuredPost->author->first_name.' '.$featuredPost->author->last_name }}"
                                             class="w-7 h-7 rounded-full border border-white">
                                        <div>
                                            <div class="font-medium text-sm">{{ $featuredPost->author->first_name.' '.$featuredPost->author->last_name }}</div>
                                            <div class="text-gray-400 text-xs">{{ $featuredPost->published_date }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-gray-400 text-xs gap-1">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ number_format($featuredPost->views_count) }} views</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endif

            <!-- Articles Grid -->
            <section class="py-10 bg-black">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                    <!-- Loading indicator -->
                    <div id="loadingIndicator" class="hidden text-center py-6">
                        <div class="inline-flex items-center gap-2">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-white"></div>
                            <span class="text-white text-sm">Loading more articles...</span>
                        </div>
                    </div>

                    <!-- Articles Container -->
                    <div id="articlesContainer" class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                        @include('common.blog-cards', ['blogs' => $blogs])
                    </div>

                    <!-- Load More Button -->
                    @if($blogs->hasMorePages())
                    <div class="text-center mt-8" id="loadMoreContainer">
                        <button id="loadMoreBtn"
                                class="btn-outline"
                                style="padding:10px 28px;font-size:.9rem;"
                                data-page="{{ $blogs->currentPage() + 1 }}"
                                data-category="{{ request('category', 'all') }}"
                                data-search="{{ request('search') }}">
                            <i class="fas fa-plus"></i> Load More Articles
                        </button>
                    </div>
                    @endif

                    <!-- No results message -->
                    <div id="noResultsMessage" class="hidden text-center py-12">
                        <div class="text-gray-400">
                            <i class="fas fa-search text-3xl mb-3 block"></i>
                            <p class="text-sm">No articles found matching your criteria.</p>
                            <p class="text-xs mt-1 text-gray-500">Try adjusting your search or category filter.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Newsletter -->
            <section class="py-10 bg-black border-t section-line">
                <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <div class="p-5 rounded-xl" style="background:#111111;border:1px solid #222222;">
                        <h3 class="text-xl font-bold mb-2">Stay Updated</h3>
                        <p class="text-gray-400 text-sm mb-4">Get the latest articles and tutorials directly in your inbox. No spam, unsubscribe anytime.</p>
                        <div class="flex flex-col sm:flex-row gap-3 max-w-sm mx-auto">
                            <input type="email" placeholder="Enter your email"
                                   class="flex-1 bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white text-sm focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent">
                            <button class="btn-brand" style="padding:10px 20px;font-size:.875rem;">
                                Subscribe
                            </button>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const articlesContainer = document.getElementById('articlesContainer');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const loadMoreContainer = document.getElementById('loadMoreContainer');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const searchInput = document.getElementById('searchInput');
    const categoryFilters = document.querySelectorAll('.category-filter');

    let isLoading = false;
    let currentCategory = '{{ request("category", "all") }}';
    let currentSearch = '{{ request("search") }}';

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            if (isLoading) return;
            isLoading = true;
            loadingIndicator.classList.remove('hidden');
            loadMoreBtn.disabled = true;

            const page = parseInt(this.dataset.page);
            const category = this.dataset.category;
            const search = this.dataset.search;

            fetch(`{{ route('blog.load-more') }}?page=${page}&category=${category}&search=${encodeURIComponent(search)}&exclude_featured=1`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.html) {
                    articlesContainer.insertAdjacentHTML('beforeend', data.html);
                    if (data.has_more) {
                        this.dataset.page = data.next_page;
                    } else {
                        if (loadMoreContainer) loadMoreContainer.style.display = 'none';
                    }
                }
            })
            .catch(console.error)
            .finally(() => {
                isLoading = false;
                loadingIndicator.classList.add('hidden');
                loadMoreBtn.disabled = false;
            });
        });
    }

    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = this.value;
                filterAndLoad();
            }, 500);
        });
    }

    categoryFilters.forEach(button => {
        button.addEventListener('click', function() {
            categoryFilters.forEach(btn => {
                btn.classList.remove('bg-white', 'text-black');
                btn.classList.add('bg-gray-800', 'text-white', 'hover:bg-gray-700');
            });
            this.classList.remove('bg-gray-800', 'text-white', 'hover:bg-gray-700');
            this.classList.add('bg-white', 'text-black');
            currentCategory = this.dataset.category;
            filterAndLoad();
        });
    });

    function filterAndLoad() {
        if (isLoading) return;
        isLoading = true;
        loadingIndicator.classList.remove('hidden');

        const params = new URLSearchParams({ category: currentCategory, search: currentSearch, exclude_featured: '1' });

        fetch(`{{ route('blog') }}?${params}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newArticles = doc.querySelector('#articlesContainer');
            const newLoadMoreBtn = doc.querySelector('#loadMoreBtn');

            if (newArticles) {
                articlesContainer.innerHTML = newArticles.innerHTML;
                if (newLoadMoreBtn) {
                    if (loadMoreBtn) {
                        loadMoreBtn.dataset.page = newLoadMoreBtn.dataset.page;
                        loadMoreBtn.dataset.category = currentCategory;
                        loadMoreBtn.dataset.search = currentSearch;
                    }
                    if (loadMoreContainer) loadMoreContainer.style.display = 'block';
                } else {
                    if (loadMoreContainer) loadMoreContainer.style.display = 'none';
                }
                if (noResultsMessage) {
                    noResultsMessage.classList.toggle('hidden', newArticles.children.length > 0);
                }
            } else {
                if (noResultsMessage) noResultsMessage.classList.remove('hidden');
            }
        })
        .catch(console.error)
        .finally(() => {
            isLoading = false;
            loadingIndicator.classList.add('hidden');
        });
    }
});
</script>
@endsection
