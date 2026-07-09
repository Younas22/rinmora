@extends('common.layout')
@section('content')

<style>
    /* Sitemap Styles */
    .sitemap-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    .sitemap-category {
        background: #1a1a1a;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #333333;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .sitemap-category::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.02) 0%, transparent 100%);
        pointer-events: none;
    }
    
    .sitemap-category:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(255,255,255,0.1);
        border-color: #4b5563;
    }
    
    .sitemap-category-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .sitemap-category-icon {
        width: 1.75rem;
        height: 1.75rem;
        background: linear-gradient(135deg, #ffffff 0%, #9ca3af 100%);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }
    
    .sitemap-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .sitemap-links li {
        margin-bottom: 0.5rem;
    }
    
    .sitemap-links a {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #9ca3af;
        text-decoration: none;
        font-size: 0.875rem;
        padding: 0.5rem;
        border-radius: 6px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .sitemap-links a:hover {
        color: #ffffff;
        background: rgba(255,255,255,0.05);
        border-color: #333333;
        transform: translateX(3px);
    }
    
    .sitemap-links .link-icon {
        font-size: 0.875rem;
        width: 1rem;
        text-align: center;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .sitemap-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .sitemap-category {
            padding: 1.25rem;
        }
    }
</style>

<section class="py-12 bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Sitemap</h2>
            <p class="text-xl text-gray-400">Navigate through all pages and sections</p>
        </div>

        <div class="space-y-6">
            <div class="sitemap-grid">
                <!-- Main Pages -->
                <div class="sitemap-category">
                    <h3 class="sitemap-category-title">
                        <div class="sitemap-category-icon">
                            <i class="fas fa-home" style="color: #000000;"></i>
                        </div>
                        Main Pages
                    </h3>
                    <ul class="sitemap-links">
                        <li>
                            <a href="{{ url('/') }}">
                                <span class="link-icon">🏠</span>
                                <span>Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/about') }}">
                                <span class="link-icon">ℹ️</span>
                                <span>About Us</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/services') }}">
                                <span class="link-icon">⚙️</span>
                                <span>Services</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/projects') }}">
                                <span class="link-icon">💼</span>
                                <span>Projects</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Content Pages -->
                <div class="sitemap-category">
                    <h3 class="sitemap-category-title">
                        <div class="sitemap-category-icon">
                            <i class="fas fa-file-alt" style="color: #000000;"></i>
                        </div>
                        Content
                    </h3>
                    <ul class="sitemap-links">
                        <li>
                            <a href="{{ url('/blogs') }}">
                                <span class="link-icon">📝</span>
                                <span>Blog</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/faq') }}">
                                <span class="link-icon">❓</span>
                                <span>FAQ</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/contact') }}">
                                <span class="link-icon">📞</span>
                                <span>Contact</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection