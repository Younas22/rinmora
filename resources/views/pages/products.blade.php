<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Products Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .product-card {
            transition: all 0.3s ease;
            background: white;
            border: 2px solid #e5e7eb;
        }
        
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: #000;
        }
        
        .filter-btn {
            transition: all 0.2s ease;
        }
        
        .filter-btn.active {
            background: #000;
            color: white;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #000;
            box-shadow: 0 0 0 3px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background: #000;
            color: white;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background: #374151;
        }
        
        .btn-secondary {
            background: white;
            color: #000;
            border: 2px solid #000;
            transition: all 0.2s ease;
        }
        
        .btn-secondary:hover {
            background: #000;
            color: white;
        }
        
        .category-badge {
            background: #f3f4f6;
            color: #374151;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-weight: 500;
        }
        
        .price-tag {
            background: #000;
            color: white;
            font-weight: 700;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 1rem;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .hidden-product {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b-2 border-black sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-black text-white rounded-lg flex items-center justify-center font-bold text-xl">
                        D
                    </div>
                    <h1 class="text-2xl font-bold text-black">Digital Store</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-600 hover:text-black">
                        <i class="fas fa-heart text-xl"></i>
                    </button>
                    <button class="text-gray-600 hover:text-black relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section - Reduced Size -->
    <section class="bg-white py-6">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-black mb-2">Premium Digital Products</h2>
            <p class="text-gray-600 mb-4">High-quality digital solutions for modern businesses</p>
            <div class="flex flex-wrap justify-center gap-4 text-sm text-gray-500">
                <div class="flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    Instant Download
                </div>
                <div class="flex items-center">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Money Back Guarantee
                </div>
                <div class="flex items-center">
                    <i class="fas fa-headset mr-2"></i>
                    24/7 Support
                </div>
            </div>
        </div>
    </section>

    <!-- Search & Filters -->
    <section class="bg-gray-100 py-6">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto mb-6">
                <div class="relative">
                    <input 
                        type="text" 
                        id="searchInput"
                        placeholder="Search products..." 
                        class="search-input w-full px-6 py-3 text-lg border-2 border-gray-300 rounded-lg bg-white"
                    >
                    <i class="fas fa-search absolute right-6 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl"></i>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-3 mb-6">
                <button class="filter-btn active px-5 py-2 rounded-full font-medium bg-black text-white text-sm" data-category="all">
                    All Products
                </button>
                <button class="filter-btn px-5 py-2 rounded-full font-medium bg-white text-black border-2 border-gray-300 hover:border-black text-sm" data-category="web-development">
                    Web Development
                </button>
                <button class="filter-btn px-5 py-2 rounded-full font-medium bg-white text-black border-2 border-gray-300 hover:border-black text-sm" data-category="mobile-apps">
                    Mobile Apps
                </button>
                <button class="filter-btn px-5 py-2 rounded-full font-medium bg-white text-black border-2 border-gray-300 hover:border-black text-sm" data-category="templates">
                    Templates
                </button>
                <button class="filter-btn px-5 py-2 rounded-full font-medium bg-white text-black border-2 border-gray-300 hover:border-black text-sm" data-category="tools">
                    Tools & Scripts
                </button>
                <button class="filter-btn px-5 py-2 rounded-full font-medium bg-white text-black border-2 border-gray-300 hover:border-black text-sm" data-category="graphics">
                    Graphics
                </button>
            </div>

            <!-- Sort & View Options -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                <div class="text-gray-600 mb-4 sm:mb-0">
                    <span id="productCount">8</span> products found
                </div>
                <div class="flex items-center space-x-4">
                    <select id="sortSelect" class="px-4 py-2 border-2 border-gray-300 rounded-lg bg-white text-black focus:border-black focus:outline-none">
                        <option value="featured">Featured</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="newest">Newest First</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="bg-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                <!-- Product 1 -->
                <div class="product-card rounded-xl p-5 fade-in" data-category="web-development" data-price="149" data-name="Laravel E-commerce Platform">
                    <div class="mb-4">
                        <div class="w-full h-36 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
                        </div>
                        <div class="category-badge inline-block mb-2">Web Development</div>
                        <h3 class="text-lg font-bold text-black mb-2 leading-tight">Laravel E-commerce Platform</h3>
                        <p class="text-gray-600 text-sm mb-3">Complete e-commerce solution with admin panel, payment gateway integration, and modern UI.</p>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <div class="text-sm font-bold text-gray-400 line-through">$199</div>
                            <div class="price-tag">$149</div>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-shopping-cart mr-1"></i>Buy Now
                            </button>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-play mr-1"></i>Demo
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-secondary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-info-circle mr-1"></i>Details
                            </button>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-book mr-1"></i>Docs
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="product-card rounded-xl p-5 fade-in" data-category="mobile-apps" data-price="199" data-name="React Native Food App">
                    <div class="mb-4">
                        <div class="w-full h-36 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-mobile-alt text-3xl text-gray-400"></i>
                        </div>
                        <div class="category-badge inline-block mb-2">Mobile Apps</div>
                        <h3 class="text-lg font-bold text-black mb-2 leading-tight">React Native Food App</h3>
                        <p class="text-gray-600 text-sm mb-3">Full-featured food delivery app with real-time tracking and payment integration.</p>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <div class="text-sm font-bold text-gray-400 line-through">$249</div>
                            <div class="price-tag">$199</div>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="far fa-star text-xs"></i>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-shopping-cart mr-1"></i>Buy Now
                            </button>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-play mr-1"></i>Demo
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-secondary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-info-circle mr-1"></i>Details
                            </button>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-book mr-1"></i>Docs
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="product-card rounded-xl p-5 fade-in" data-category="templates" data-price="49" data-name="Modern Dashboard Template">
                    <div class="mb-4">
                        <div class="w-full h-36 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-chart-bar text-3xl text-gray-400"></i>
                        </div>
                        <div class="category-badge inline-block mb-2">Templates</div>
                        <h3 class="text-lg font-bold text-black mb-2 leading-tight">Modern Dashboard Template</h3>
                        <p class="text-gray-600 text-sm mb-3">Clean and responsive dashboard template with dark/light mode support.</p>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <div class="text-sm font-bold text-gray-400 line-through">$69</div>
                            <div class="price-tag">$49</div>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-shopping-cart mr-1"></i>Buy Now
                            </button>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-play mr-1"></i>Demo
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-secondary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-info-circle mr-1"></i>Details
                            </button>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-book mr-1"></i>Docs
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="product-card rounded-xl p-5 fade-in" data-category="tools" data-price="79" data-name="API Documentation Generator">
                    <div class="mb-4">
                        <div class="w-full h-36 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-code text-3xl text-gray-400"></i>
                        </div>
                        <div class="category-badge inline-block mb-2">Tools & Scripts</div>
                        <h3 class="text-lg font-bold text-black mb-2 leading-tight">API Documentation Generator</h3>
                        <p class="text-gray-600 text-sm mb-3">Automatically generate beautiful API documentation from your code comments.</p>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <div class="text-sm font-bold text-gray-400 line-through">$99</div>
                            <div class="price-tag">$79</div>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="far fa-star text-xs"></i>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-shopping-cart mr-1"></i>Buy Now
                            </button>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-play mr-1"></i>Demo
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-secondary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-info-circle mr-1"></i>Details
                            </button>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-book mr-1"></i>Docs
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="product-card rounded-xl p-5 fade-in" data-category="graphics" data-price="29" data-name="Icon Pack Collection">
                    <div class="mb-4">
                        <div class="w-full h-36 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-icons text-3xl text-gray-400"></i>
                        </div>
                        <div class="category-badge inline-block mb-2">Graphics</div>
                        <h3 class="text-lg font-bold text-black mb-2 leading-tight">Icon Pack Collection</h3>
                        <p class="text-gray-600 text-sm mb-3">500+ premium icons in multiple formats (SVG, PNG, ICO) for web and mobile.</p>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <div class="text-sm font-bold text-gray-400 line-through">$39</div>
                            <div class="price-tag">$29</div>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-shopping-cart mr-1"></i>Buy Now
                            </button>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-play mr-1"></i>Demo
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-secondary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-info-circle mr-1"></i>Details
                            </button>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-book mr-1"></i>Docs
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="product-card rounded-xl p-5 fade-in" data-category="web-development" data-price="89" data-name="CMS Content Management">
                    <div class="mb-4">
                        <div class="w-full h-36 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-edit text-3xl text-gray-400"></i>
                        </div>
                        <div class="category-badge inline-block mb-2">Web Development</div>
                        <h3 class="text-lg font-bold text-black mb-2 leading-tight">CMS Content Management</h3>
                        <p class="text-gray-600 text-sm mb-3">User-friendly content management system with drag-and-drop page builder.</p>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <div class="text-sm font-bold text-gray-400 line-through">$119</div>
                            <div class="price-tag">$89</div>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="far fa-star text-xs"></i>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-shopping-cart mr-1"></i>Buy Now
                            </button>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-play mr-1"></i>Demo
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-secondary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-info-circle mr-1"></i>Details
                            </button>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-book mr-1"></i>Docs
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 7 -->
                <div class="product-card rounded-xl p-5 fade-in" data-category="mobile-apps" data-price="159" data-name="Fitness Tracker App">
                    <div class="mb-4">
                        <div class="w-full h-36 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-heartbeat text-3xl text-gray-400"></i>
                        </div>
                        <div class="category-badge inline-block mb-2">Mobile Apps</div>
                        <h3 class="text-lg font-bold text-black mb-2 leading-tight">Fitness Tracker App</h3>
                        <p class="text-gray-600 text-sm mb-3">Complete fitness tracking app with workout plans and progress monitoring.</p>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <div class="text-sm font-bold text-gray-400 line-through">$199</div>
                            <div class="price-tag">$159</div>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-shopping-cart mr-1"></i>Buy Now
                            </button>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-play mr-1"></i>Demo
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-secondary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-info-circle mr-1"></i>Details
                            </button>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-book mr-1"></i>Docs
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 8 -->
                <div class="product-card rounded-xl p-5 fade-in" data-category="templates" data-price="39" data-name="Landing Page Templates">
                    <div class="mb-4">
                        <div class="w-full h-36 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-desktop text-3xl text-gray-400"></i>
                        </div>
                        <div class="category-badge inline-block mb-2">Templates</div>
                        <h3 class="text-lg font-bold text-black mb-2 leading-tight">Landing Page Templates</h3>
                        <p class="text-gray-600 text-sm mb-3">10 high-converting landing page templates for different industries.</p>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <div class="text-sm font-bold text-gray-400 line-through">$59</div>
                            <div class="price-tag">$39</div>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="far fa-star text-xs"></i>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-shopping-cart mr-1"></i>Buy Now
                            </button>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-play mr-1"></i>Demo
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-secondary flex-1 py-1.5 px-3 rounded-md font-medium text-xs">
                                <i class="fas fa-info-circle mr-1"></i>Details
                            </button>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1.5 rounded-md text-xs font-medium">
                                <i class="fas fa-book mr-1"></i>Docs
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Load More Button -->
            <div class="text-center mt-8">
                <button class="btn-secondary px-6 py-2 rounded-lg font-medium text-sm">
                    Load More Products
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-6">
                <div>
                    <h3 class="text-lg font-bold mb-3">Digital Store</h3>
                    <p class="text-gray-400 text-sm">Premium digital products for modern businesses and developers.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-3">Categories</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white">Web Development</a></li>
                        <li><a href="#" class="hover:text-white">Mobile Apps</a></li>
                        <li><a href="#" class="hover:text-white">Templates</a></li>
                        <li><a href="#" class="hover:text-white">Graphics</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-3">Support</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white">Help Center</a></li>
                        <li><a href="#" class="hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white">Refund Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-3">Connect</h4>
                    <div class="flex space-x-3">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter text-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-lg"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-6 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; 2025 Digital Store. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const productCards = document.querySelectorAll('.product-card');
        const productCount = document.getElementById('productCount');
        const searchInput = document.getElementById('searchInput');
        const sortSelect = document.getElementById('sortSelect');

        // Filter by category
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.classList.add('bg-white', 'text-black', 'border-2', 'border-gray-300');
                    btn.classList.remove('bg-black', 'text-white');
                });

                // Add active class to clicked button
                button.classList.add('active');
                button.classList.remove('bg-white', 'text-black', 'border-2', 'border-gray-300');
                button.classList.add('bg-black', 'text-white');

                const category = button.getAttribute('data-category');
                filterProducts(category);
            });
        });

        // Search functionality
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            filterProducts(null, searchTerm);
        });

        // Sort functionality
        sortSelect.addEventListener('change', (e) => {
            sortProducts(e.target.value);
        });

        function filterProducts(category = null, searchTerm = '') {
            let visibleCount = 0;
            const activeCategory = category || document.querySelector('.filter-btn.active').getAttribute('data-category');

            productCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                const cardName = card.getAttribute('data-name').toLowerCase();
                
                const matchesCategory = activeCategory === 'all' || cardCategory === activeCategory;
                const matchesSearch = searchTerm === '' || cardName.includes(searchTerm);

                if (matchesCategory && matchesSearch) {
                    card.style.display = 'block';
                    card.classList.add('fade-in');
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            productCount.textContent = visibleCount;
        }

        function sortProducts(sortType) {
            const productsGrid = document.getElementById('productsGrid');
            const products = Array.from(productCards);

            products.sort((a, b) => {
                switch (sortType) {
                    case 'price-low':
                        return parseInt(a.getAttribute('data-price')) - parseInt(b.getAttribute('data-price'));
                    case 'price-high':
                        return parseInt(b.getAttribute('data-price')) - parseInt(a.getAttribute('data-price'));
                    case 'newest':
                        return Math.random() - 0.5; // Random for demo
                    case 'popular':
                        return Math.random() - 0.5; // Random for demo
                    default:
                        return 0;
                }
            });

            // Clear and re-append sorted products
            productsGrid.innerHTML = '';
            products.forEach(product => {
                productsGrid.appendChild(product);
            });
        }

        // Initialize with all products visible
        filterProducts('all');
    </script>
</body>
</html>