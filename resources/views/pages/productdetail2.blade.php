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
        
        .product-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 1rem;
            border: 2px solid #e5e7eb;
        }
        
        .feature-item {
            padding: 1rem;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .feature-item:hover {
            border-color: #000;
            transform: translateY(-2px);
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

    <!-- Main Content -->
    <section class="bg-white py-8">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Product Image -->
                <div>
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=500&fit=crop" alt="Laravel E-commerce Platform" class="product-image">
                </div>

                <!-- Product Details -->
                <div>
                    <!-- Category & Title -->
                    <div class="badge bg-gray-200 text-gray-700 mb-3">Web Development</div>
                    <h1 class="text-3xl font-bold text-black mb-4">Laravel E-commerce Platform</h1>
                    
                    <!-- Rating & Stats -->
                    <div class="flex items-center space-x-6 mb-6">
                        <div class="flex items-center">
                            <div class="flex text-yellow-500 mr-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-gray-600 text-sm">(4.9)</span>
                        </div>
                        <div class="text-green-600 text-sm font-medium">
                            <i class="fas fa-download mr-1"></i>250+ Downloads
                        </div>
                        <div class="text-blue-600 text-sm font-medium">
                            <i class="fas fa-comments mr-1"></i>156 Reviews
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="text-2xl font-bold text-gray-400 line-through">$199</div>
                        <div class="price-tag">$149</div>
                        <div class="bg-red-500 text-white px-3 py-1 rounded-full font-bold text-sm">25% OFF</div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-black mb-3">About This Product</h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Complete e-commerce solution built with Laravel 10. This comprehensive package includes everything you need to create a professional online store with modern features and seamless user experience.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            Features include admin panel, payment gateway integration, inventory management, multi-vendor support, and responsive design that works perfectly on all devices.
                        </p>
                    </div>

                    <!-- Tech Stack -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-black mb-3">Technologies Used</h3>
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
                    <div class="space-y-3 mb-8">
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

                    <!-- What's Included -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-black mb-4">What's Included</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                Full Source Code
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                Installation Guide
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                Video Tutorials
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                6 Months Support
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                Free Updates
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                Commercial License
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="bg-gray-50 py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-black text-center mb-8">Key Features</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="feature-item text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Advanced Shopping Cart</h3>
                    <p class="text-gray-600 text-sm">Persistent cart with save for later and guest checkout options.</p>
                </div>

                <div class="feature-item text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Multiple Payment Gateways</h3>
                    <p class="text-gray-600 text-sm">Integrated with Stripe, PayPal, and Razorpay for secure payments.</p>
                </div>

                <div class="feature-item text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Analytics Dashboard</h3>
                    <p class="text-gray-600 text-sm">Comprehensive admin dashboard with sales analytics and insights.</p>
                </div>

                <div class="feature-item text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Mobile Responsive</h3>
                    <p class="text-gray-600 text-sm">Fully responsive design that works great on all devices.</p>
                </div>

                <div class="feature-item text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Multi-Vendor Support</h3>
                    <p class="text-gray-600 text-sm">Built-in marketplace functionality for multiple vendors.</p>
                </div>

                <div class="feature-item text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-cog text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Easy Customization</h3>
                    <p class="text-gray-600 text-sm">Clean code structure makes customization simple and fast.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Requirements Section -->
    <section class="bg-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-black text-center mb-8">System Requirements</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-200">
                    <h3 class="text-lg font-bold mb-4">Server Requirements</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            PHP 8.1 or higher
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            MySQL 5.7 or higher
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Apache/Nginx web server
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Composer dependency manager
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Node.js & NPM (for assets)
                        </li>
                    </ul>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-200">
                    <h3 class="text-lg font-bold mb-4">PHP Extensions</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            OpenSSL Extension
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            PDO PHP Extension
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Mbstring PHP Extension
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Tokenizer PHP Extension
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            XML PHP Extension
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Reviews -->
    <section class="bg-gray-50 py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-black text-center mb-8">Customer Reviews</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl border-2 border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <div>
                            <h4 class="font-bold">John Smith</h4>
                            <div class="flex text-yellow-500">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">
                        "Excellent Laravel e-commerce solution! The code quality is outstanding and the documentation is very detailed. Set up my store in just a few hours."
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl border-2 border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <div>
                            <h4 class="font-bold">Sarah Johnson</h4>
                            <div class="flex text-yellow-500">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">
                        "Great support team and amazing product! The admin panel is very user-friendly and the payment integration works flawlessly. Highly recommended!"
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl border-2 border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <div>
                            <h4 class="font-bold">Mike Chen</h4>
                            <div class="flex text-yellow-500">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="far fa-star text-sm"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">
                        "Solid e-commerce platform with good features. The multi-vendor functionality is exactly what I needed for my marketplace project."
                    </p>
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
</body>
</html>