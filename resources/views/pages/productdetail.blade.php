<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel E-commerce Platform - Digital Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
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
        
        .feature-card {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }
        
        .feature-card:hover {
            border-color: #000;
            transform: translateY(-2px);
        }
        
        .gallery-item {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid transparent;
        }
        
        .gallery-item.active {
            border-color: #000;
        }
        
        .gallery-item:hover {
            border-color: #666;
        }
        
        .price-tag {
            background: #000;
            color: white;
            font-weight: 700;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            font-size: 1.25rem;
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .tech-badge {
            background: #f3f4f6;
            color: #374151;
        }
        
        .review-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .review-card:hover {
            border-color: #000;
            transform: translateY(-2px);
        }
        
        .tab-btn {
            padding: 0.75rem 1.5rem;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .tab-btn.active {
            border-bottom-color: #000;
            color: #000;
            font-weight: 600;
        }
        
        .tab-btn:hover {
            color: #000;
        }
        
        .main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 0.75rem;
            border: 2px solid #e5e7eb;
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
                    <a href="#" class="text-gray-600 hover:text-black transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Products
                    </a>
                    <div class="flex items-center space-x-3">
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
        </div>
    </header>

    <!-- Breadcrumb -->
    <section class="bg-white py-4 border-b">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-sm text-gray-600">
                <a href="#" class="hover:text-black">Home</a>
                <span class="mx-2">/</span>
                <a href="#" class="hover:text-black">Web Development</a>
                <span class="mx-2">/</span>
                <span class="text-black font-medium">Laravel E-commerce Platform</span>
            </nav>
        </div>
    </section>

    <!-- Product Details -->
    <section class="bg-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div>
                    <div class="mb-4">
                        <img id="mainImage" src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop" alt="Laravel E-commerce Platform" class="main-image">
                    </div>
                    <div class="grid grid-cols-4 gap-3">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=150&h=150&fit=crop" alt="Screenshot 1" class="gallery-item active w-full h-20 object-cover rounded-lg" onclick="changeMainImage(this.src)">
                        <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=150&h=150&fit=crop" alt="Screenshot 2" class="gallery-item w-full h-20 object-cover rounded-lg" onclick="changeMainImage(this.src)">
                        <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=150&h=150&fit=crop" alt="Screenshot 3" class="gallery-item w-full h-20 object-cover rounded-lg" onclick="changeMainImage(this.src)">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=150&h=150&fit=crop" alt="Screenshot 4" class="gallery-item w-full h-20 object-cover rounded-lg" onclick="changeMainImage(this.src)">
                    </div>
                </div>

                <!-- Product Info -->
                <div>
                    <div class="badge bg-gray-200 text-gray-700 mb-3">Web Development</div>
                    <h1 class="text-3xl font-bold text-black mb-4">Laravel E-commerce Platform</h1>
                    
                    <!-- Rating & Reviews -->
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-500 mr-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-gray-600 text-sm">(4.9) • 156 Reviews</span>
                        <span class="ml-4 text-green-600 text-sm font-medium">250+ Downloads</span>
                    </div>

                    <!-- Price -->
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="text-2xl font-bold text-gray-400 line-through">$199</div>
                        <div class="price-tag">$149</div>
                        <div class="bg-red-500 text-white px-3 py-1 rounded-full font-bold">25% OFF</div>
                    </div>

                    <!-- Short Description -->
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        Complete e-commerce solution built with Laravel 10. Includes admin panel, payment gateway integration, 
                        inventory management, and modern responsive UI. Perfect for building professional online stores.
                    </p>

                    <!-- Tech Stack -->
                    <div class="mb-6">
                        <h3 class="font-bold text-black mb-3">Tech Stack:</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="tech-badge">Laravel 10</span>
                            <span class="tech-badge">Vue.js 3</span>
                            <span class="tech-badge">MySQL</span>
                            <span class="tech-badge">Stripe API</span>
                            <span class="tech-badge">PayPal</span>
                            <span class="tech-badge">Bootstrap 5</span>
                            <span class="tech-badge">Redis</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3 mb-6">
                        <div class="flex space-x-3">
                            <button class="btn-primary flex-1 py-3 px-6 rounded-lg font-medium">
                                <i class="fas fa-shopping-cart mr-2"></i>Buy Now - $149
                            </button>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                                <i class="fas fa-play mr-2"></i>Live Demo
                            </button>
                        </div>
                        <div class="flex space-x-3">
                            <button class="btn-secondary flex-1 py-2 px-4 rounded-lg font-medium text-sm">
                                <i class="fas fa-heart mr-2"></i>Add to Wishlist
                            </button>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium text-sm">
                                <i class="fas fa-book mr-2"></i>Documentation
                            </button>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="border-t pt-6">
                        <h3 class="font-bold text-black mb-3">What's Included:</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                Full Source Code
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                Installation Guide
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                Video Tutorials
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                6 Months Support
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                Free Updates
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                Commercial License
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Information Tabs -->
    <section class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Tab Navigation -->
            <div class="flex border-b border-gray-300 mb-8">
                <button class="tab-btn active" onclick="showTab('description')">Description</button>
                <button class="tab-btn" onclick="showTab('features')">Features</button>
                <button class="tab-btn" onclick="showTab('requirements')">Requirements</button>
                <button class="tab-btn" onclick="showTab('reviews')">Reviews (156)</button>
            </div>

            <!-- Tab Content -->
            <div id="description" class="tab-content">
                <div class="bg-white p-8 rounded-xl border-2 border-gray-200">
                    <h2 class="text-2xl font-bold mb-6">Complete Laravel E-commerce Solution</h2>
                    <div class="prose max-w-none">
                        <p class="mb-4">
                            Build a professional e-commerce platform with this comprehensive Laravel 10 solution. This package includes everything you need 
                            to create a modern online store with advanced features and seamless user experience.
                        </p>
                        <p class="mb-4">
                            The platform comes with a powerful admin dashboard, complete inventory management, multiple payment gateways, 
                            and responsive design that works perfectly on all devices.
                        </p>
                        <h3 class="text-xl font-bold mt-6 mb-4">Key Highlights:</h3>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Multi-vendor marketplace support</li>
                            <li>Advanced product management with variants</li>
                            <li>Integrated payment processing (Stripe, PayPal, Razorpay)</li>
                            <li>Order tracking and management system</li>
                            <li>Customer review and rating system</li>
                            <li>SEO optimized pages and URLs</li>
                            <li>Email notifications and templates</li>
                            <li>Coupon and discount management</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="features" class="tab-content hidden">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="feature-card bg-white p-6 rounded-xl">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold mb-3">Advanced Shopping Cart</h3>
                        <p class="text-gray-600 text-sm">Persistent shopping cart with save for later, quantity updates, and guest checkout options.</p>
                    </div>
                    <div class="feature-card bg-white p-6 rounded-xl">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-credit-card text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold mb-3">Multiple Payment Gateways</h3>
                        <p class="text-gray-600 text-sm">Integrated with Stripe, PayPal, and Razorpay for secure payment processing worldwide.</p>
                    </div>
                    <div class="feature-card bg-white p-6 rounded-xl">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold mb-3">Analytics Dashboard</h3>
                        <p class="text-gray-600 text-sm">Comprehensive admin dashboard with sales analytics, user insights, and performance metrics.</p>
                    </div>
                    <div class="feature-card bg-white p-6 rounded-xl">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-mobile-alt text-red-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold mb-3">Mobile Responsive</h3>
                        <p class="text-gray-600 text-sm">Fully responsive design that looks great on desktop, tablet, and mobile devices.</p>
                    </div>
                </div>
            </div>

            <div id="requirements" class="tab-content hidden">
                <div class="bg-white p-8 rounded-xl border-2 border-gray-200">
                    <h2 class="text-2xl font-bold mb-6">System Requirements</h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-bold mb-4">Server Requirements</h3>
                            <ul class="space-y-2 text-gray-700">
                                <li><i class="fas fa-check text-green-600 mr-2"></i>PHP 8.1 or higher</li>
                                <li><i class="fas fa-check text-green-600 mr-2"></i>MySQL 5.7 or higher</li>
                                <li><i class="fas fa-check text-green-600 mr-2"></i>Apache/Nginx web server</li>
                                <li><i class="fas fa-check text-green-600 mr-2"></i>Composer dependency manager</li>
                                <li><i class="fas fa-check text-green-600 mr-2"></i>Node.js & NPM (for assets)</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-4">PHP Extensions</h3>
                            <ul class="space-y-2 text-gray-700">
                                <li><i class="fas fa-check text-green-600 mr-2"></i>OpenSSL</li>
                                <li><i class="fas fa-check text-green-600 mr-2"></i>PDO</li>
                                <li><i class="fas fa-check text-green-600 mr-2"></i>Mbstring</li>
                                <li><i class="fas fa-check text-green-600 mr-2"></i>Tokenizer</li>
                                <li><i class="fas fa-check text-green-600 mr-2"></i>XML</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id="reviews" class="tab-content hidden">
                <div class="space-y-6">
                    <div class="review-card">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-bold">John Smith</h4>
                                    <div class="flex text-yellow-500">
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-2">
                                    "Excellent Laravel e-commerce solution! The code quality is outstanding and the documentation 
                                    is very detailed. Set up my store in just a few hours."
                                </p>
                                <span class="text-xs text-gray-400">2 days ago</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-bold">Sarah Johnson</h4>
                                    <div class="flex text-yellow-500">
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-2">
                                    "Great support team and amazing product! The admin panel is very user-friendly and the 
                                    payment integration works flawlessly. Highly recommended!"
                                </p>
                                <span class="text-xs text-gray-400">1 week ago</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-bold">Mike Chen</h4>
                                    <div class="flex text-yellow-500">
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="far fa-star text-sm"></i>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-2">
                                    "Solid e-commerce platform with good features. The multi-vendor functionality is exactly 
                                    what I needed for my marketplace project."
                                </p>
                                <span class="text-xs text-gray-400">2 weeks ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-black mb-8">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Related Product 1 -->
                <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4 hover:border-black transition-all">
                    <div class="w-full h-32 bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                        <i class="fas fa-mobile-alt text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="font-bold text-sm mb-2">React Native Food App</h3>
                    <div class="flex items-center justify-between">
                        <div class="text-sm">
                            <span class="text-gray-400 line-through">$249</span>
                            <span class="font-bold ml-2">$199</span>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="far fa-star text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Related Product 2 -->
                <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4 hover:border-black transition-all">
                    <div class="w-full h-32 bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                        <i class="fas fa-chart-bar text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="font-bold text-sm mb-2">Dashboard Template</h3>
                    <div class="flex items-center justify-between">
                        <div class="text-sm">
                            <span class="text-gray-400 line-through">$69</span>
                            <span class="font-bold ml-2">$49</span>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Related Product 3 -->
                <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4 hover:border-black transition-all">
                    <div class="w-full h-32 bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                        <i class="fas fa-edit text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="font-bold text-sm mb-2">CMS System</h3>
                    <div class="flex items-center justify-between">
                        <div class="text-sm">
                            <span class="text-gray-400 line-through">$119</span>
                            <span class="font-bold ml-2">$89</span>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="far fa-star text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Related Product 4 -->
                <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4 hover:border-black transition-all">
                    <div class="w-full h-32 bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                        <i class="fas fa-code text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="font-bold text-sm mb-2">API Generator</h3>
                    <div class="flex items-center justify-between">
                        <div class="text-sm">
                            <span class="text-gray-400 line-through">$99</span>
                            <span class="font-bold ml-2">$79</span>
                        </div>
                        <div class="flex text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="far fa-star text-xs"></i>
                        </div>
                    </div>
                </div>
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
        // Tab functionality
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-btn');
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });

            // Show selected tab content
            document.getElementById(tabName).classList.remove('hidden');

            // Add active class to clicked button
            event.target.classList.add('active');
        }

        // Gallery functionality
        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
            
            // Remove active class from all gallery items
            const galleryItems = document.querySelectorAll('.gallery-item');
            galleryItems.forEach(item => {
                item.classList.remove('active');
            });
            
            // Add active class to clicked item
            event.target.classList.add('active');
        }

        // Add to cart functionality
        function addToCart() {
            // Update cart count
            const cartCount = document.querySelector('.fa-shopping-cart + span');
            let currentCount = parseInt(cartCount.textContent);
            cartCount.textContent = currentCount + 1;
            
            // Show success message (you can customize this)
            alert('Product added to cart!');
        }
    </script>
</body>
</html>