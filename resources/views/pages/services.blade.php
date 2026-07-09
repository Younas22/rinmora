@extends('common.layout')
@section('content')

    <!-- Hero Section -->
    <section class="py-16 md:py-24 bg-gradient-to-r from-gray-900 to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Professional <span class="gradient-text">Development Services</span>
                </h1>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto mb-8">
                    Comprehensive Laravel & PHP solutions tailored to your business needs. 
                    From custom web applications to AI-powered platforms, I deliver scalable solutions that drive results.
                </p>
                
                <!-- Service Stats -->
                <div class="flex flex-wrap justify-center gap-8 mt-12">
                    <div class="text-center">
                        <div class="text-3xl font-bold gradient-text">50+</div>
                        <div class="text-gray-400">Projects Completed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold gradient-text">5+</div>
                        <div class="text-gray-400">Years Experience</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold gradient-text">15+</div>
                        <div class="text-gray-400">Technologies</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold gradient-text">100%</div>
                        <div class="text-gray-400">Client Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Service Categories -->
    <section class="py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Core Services</h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">Specialized solutions for modern web development</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <!-- Web Development -->
                <div class="bg-gray-900 p-8 rounded-xl shadow-sm border border-gray-800 card-hover">
                    <div class="w-16 h-16 gradient-bg rounded-xl flex items-center justify-center mb-6 service-icon">
                        <i class="fas fa-laptop-code text-black text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Custom Web Development</h3>
                    <p class="text-gray-400 mb-6">Bespoke web applications built with Laravel and modern PHP practices, tailored to your specific business requirements.</p>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>Custom Web Applications</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>E-commerce Solutions</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>CMS Development</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>Inventory Management Systems</span>
                        </li>
                    </ul>
                    <div class="mt-6">
                        <button class="w-full btn-primary px-6 py-3 rounded-lg font-medium">
                            Start from $2,500
                        </button>
                    </div>
                </div>

                <!-- API Development -->
                <div class="bg-gray-900 p-8 rounded-xl shadow-sm border border-gray-800 card-hover">
                    <div class="w-16 h-16 gradient-bg rounded-xl flex items-center justify-center mb-6 service-icon">
                        <i class="fas fa-server text-black text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">API Development & Integration</h3>
                    <p class="text-gray-400 mb-6">Robust API development and seamless third-party integrations for connected applications and services.</p>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>RESTful API Development</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>Third-party API Integration</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>Mobile App Backend APIs</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>Microservices Architecture</span>
                        </li>
                    </ul>
                    <div class="mt-6">
                        <button class="w-full btn-primary px-6 py-3 rounded-lg font-medium">
                            Start from $1,800
                        </button>
                    </div>
                </div>

                <!-- AI Solutions -->
                <div class="bg-gray-900 p-8 rounded-xl shadow-sm border border-gray-800 card-hover">
                    <div class="w-16 h-16 gradient-bg rounded-xl flex items-center justify-center mb-6 service-icon">
                        <i class="fas fa-robot text-black text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">AI-Powered Solutions</h3>
                    <p class="text-gray-400 mb-6">Cutting-edge AI integration and automation solutions to enhance your applications with intelligent features.</p>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>AI-powered SaaS Platforms</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>Text-to-Image Generation</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>Audio-to-Text Conversion</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span>AI Content Generation</span>
                        </li>
                    </ul>
                    <div class="mt-6">
                        <button class="w-full btn-primary px-6 py-3 rounded-lg font-medium">
                            Start from $3,500
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Integration -->
    <section class="py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Payment Gateway Integration</h2>
                <p class="text-xl text-gray-400">Secure and reliable payment processing solutions</p>
            </div>

            <div class="bg-gray-800 p-8 rounded-xl border border-gray-700 mb-16">
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- PayPal -->
                    <div class="text-center">
                        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fab fa-paypal text-white text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">PayPal Integration</h3>
                        <p class="text-gray-400 text-sm">Complete PayPal payment processing with webhooks and subscription support</p>
                    </div>

                    <!-- Stripe -->
                    <div class="text-center">
                        <div class="w-20 h-20 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-credit-card text-white text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Stripe Payment Gateway</h3>
                        <p class="text-gray-400 text-sm">Advanced Stripe integration with recurring billing and marketplace support</p>
                    </div>

                    <!-- Tazapay -->
                    <div class="text-center">
                        <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shield-alt text-white text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Tazapay Secure Payments</h3>
                        <p class="text-gray-400 text-sm">International B2B payment solutions with escrow and multi-currency support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Specialized Solutions -->
    <section class="py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Specialized Solutions</h2>
                <p class="text-xl text-gray-400">Custom solutions for specific industries and requirements</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Laravel Advanced -->
                <div class="bg-gray-900 p-6 rounded-xl shadow-sm border border-gray-800 card-hover">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4 service-icon">
                        <i class="fab fa-laravel text-black text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold mb-3">Laravel Advanced</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>• Laravel Nova/Horizon</li>
                        <li>• Queue & Job Management</li>
                        <li>• Real-time Notifications</li>
                        <li>• Multi-auth Systems</li>
                        <li>• SaaS Platform Development</li>
                    </ul>
                    <div class="mt-4">
                        <span class="text-white font-semibold">From $2,000</span>
                    </div>
                </div>

                <!-- Custom Industry Solutions -->
                <div class="bg-gray-900 p-6 rounded-xl shadow-sm border border-gray-800 card-hover">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4 service-icon">
                        <i class="fas fa-cog text-black text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold mb-3">Industry Solutions</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>• Travel Management Systems</li>
                        <li>• Healthcare Booking Portals</li>
                        <li>• Real Estate Platforms</li>
                        <li>• Educational Platforms</li>
                        <li>• Construction Management</li>
                    </ul>
                    <div class="mt-4">
                        <span class="text-white font-semibold">From $3,000</span>
                    </div>
                </div>

                <!-- Performance & Security -->
                <div class="bg-gray-900 p-6 rounded-xl shadow-sm border border-gray-800 card-hover">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4 service-icon">
                        <i class="fas fa-shield-alt text-black text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold mb-3">Performance & Security</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>• Website Speed Optimization</li>
                        <li>• Security Audits & Fixes</li>
                        <li>• Server Configuration</li>
                        <li>• Database Optimization</li>
                        <li>• Automated Deployments</li>
                    </ul>
                    <div class="mt-4">
                        <span class="text-white font-semibold">From $1,200</span>
                    </div>
                </div>

                <!-- Maintenance & Support -->
                <div class="bg-gray-900 p-6 rounded-xl shadow-sm border border-gray-800 card-hover">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4 service-icon">
                        <i class="fas fa-tools text-black text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold mb-3">Maintenance & Support</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>• 24/7 Technical Support</li>
                        <li>• Regular Updates & Patches</li>
                        <li>• Performance Monitoring</li>
                        <li>• Backup Management</li>
                        <li>• Bug Fixes & Improvements</li>
                    </ul>
                    <div class="mt-4">
                        <span class="text-white font-semibold">From $500/month</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Development Process -->
    <section class="py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">My Development Process</h2>
                <p class="text-xl text-gray-400">Streamlined workflow ensuring quality and timely delivery</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="process-step text-center">
                    <!-- <div class="process-line"></div> -->
                    <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4 relative z-10">
                        <span class="text-black font-bold text-xl">1</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Discovery & Planning</h3>
                    <p class="text-gray-400">Understanding your requirements, goals, and creating a detailed project roadmap with timeline and milestones.</p>
                </div>

                <!-- Step 2 -->
                <div class="process-step text-center">
                    <!-- <div class="process-line"></div> -->
                    <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4 relative z-10">
                        <span class="text-black font-bold text-xl">2</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Design & Architecture</h3>
                    <p class="text-gray-400">Creating system architecture, database design, and UI/UX mockups to ensure scalable and user-friendly solutions.</p>
                </div>

                <!-- Step 3 -->
                <div class="process-step text-center">
                    <!-- <div class="process-line"></div> -->
                    <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4 relative z-10">
                        <span class="text-black font-bold text-xl">3</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Development & Testing</h3>
                    <p class="text-gray-400">Agile development with regular updates, comprehensive testing, and quality assurance throughout the process.</p>
                </div>

                <!-- Step 4 -->
                <div class="process-step text-center">
                    <!-- <div class="process-line"></div> -->
                    <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4 relative z-10">
                        <span class="text-black font-bold text-xl">4</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Deployment & Support</h3>
                    <p class="text-gray-400">Smooth deployment to production environment with ongoing support, maintenance, and optimization services.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Packages -->
    <section class="py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Service Packages</h2>
                <p class="text-xl text-gray-400">Choose the perfect package for your project needs</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Starter Package -->
                <div class="pricing-card bg-gray-900 p-8 rounded-xl border border-gray-800 card-hover">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold mb-2">Starter</h3>
                        <div class="text-4xl font-bold gradient-text mb-2">$1,500</div>
                        <p class="text-gray-400">Perfect for small projects</p>
                    </div>
                    <ul class="space-y-3 text-gray-400 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Simple Laravel Application</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Basic Admin Panel</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Database Design & Setup</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Responsive Design</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>30 Days Support</span>
                        </li>
                    </ul>
                    <button class="w-full btn-primary px-6 py-3 rounded-lg font-medium">
                        Get Started
                    </button>
                </div>

                <!-- Professional Package -->
                <div class="pricing-card bg-gray-900 p-8 rounded-xl border-2 border-white relative card-hover">
                    <div class="absolute top-4 right-4 bg-white text-black px-3 py-1 rounded-full text-sm font-bold">
                        Popular
                    </div>
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold mb-2">Professional</h3>
                        <div class="text-4xl font-bold gradient-text mb-2">$3,500</div>
                        <p class="text-gray-400">For growing businesses</p>
                    </div>
                    <ul class="space-y-3 text-gray-400 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Complex Web Application</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Advanced Admin Dashboard</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>API Development</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Payment Integration</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Email Notifications</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>90 Days Support</span>
                        </li>
                    </ul>
                    <button class="w-full btn-primary px-6 py-3 rounded-lg font-medium">
                        Get Started
                    </button>
                </div>

                <!-- Enterprise Package -->
                <div class="pricing-card bg-gray-900 p-8 rounded-xl border border-gray-800 card-hover">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold mb-2">Enterprise</h3>
                        <div class="text-4xl font-bold gradient-text mb-2">$7,500+</div>
                        <p class="text-gray-400">For large-scale projects</p>
                    </div>
                    <ul class="space-y-3 text-gray-400 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Enterprise-level Application</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Microservices Architecture</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>AI Integration</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Advanced Security Features</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Performance Optimization</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>6 Months Support</span>
                        </li>
                    </ul>
                    <button class="w-full btn-primary px-6 py-3 rounded-lg font-medium">
                        Contact for Quote
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-400">Common questions about my services and process</p>
            </div>

            <div class="space-y-6">
                <!-- FAQ 1 -->
                <div class="bg-gray-800 rounded-xl border border-gray-700">
                    <button class="w-full p-6 text-left flex justify-between items-center" onclick="toggleFAQ(1)">
                        <h3 class="text-lg font-semibold">What technologies do you specialize in?</h3>
                        <i class="fas fa-chevron-down transform transition-transform" id="faq-icon-1"></i>
                    </button>
                    <div class="px-6 pb-6 hidden" id="faq-content-1">
                        <p class="text-gray-400">I specialize in PHP 8+, Laravel, JavaScript, MySQL, AWS, and various API integrations. I also work with modern frontend technologies and AI integration services like OpenAI, creating comprehensive full-stack solutions.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-gray-800 rounded-xl border border-gray-700">
                    <button class="w-full p-6 text-left flex justify-between items-center" onclick="toggleFAQ(2)">
                        <h3 class="text-lg font-semibold">How long does a typical project take?</h3>
                        <i class="fas fa-chevron-down transform transition-transform" id="faq-icon-2"></i>
                    </button>
                    <div class="px-6 pb-6 hidden" id="faq-content-2">
                        <p class="text-gray-400">Project timelines vary based on complexity. Simple applications take 2-4 weeks, medium complexity projects take 1-2 months, and enterprise-level applications can take 3-6 months. I provide detailed timelines during the planning phase.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-gray-800 rounded-xl border border-gray-700">
                    <button class="w-full p-6 text-left flex justify-between items-center" onclick="toggleFAQ(3)">
                        <h3 class="text-lg font-semibold">Do you provide ongoing support and maintenance?</h3>
                        <i class="fas fa-chevron-down transform transition-transform" id="faq-icon-3"></i>
                    </button>
                    <div class="px-6 pb-6 hidden" id="faq-content-3">
                        <p class="text-gray-400">Yes, I offer comprehensive support and maintenance packages starting from $500/month. This includes bug fixes, security updates, performance monitoring, regular backups, and feature enhancements as needed.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-gray-800 rounded-xl border border-gray-700">
                    <button class="w-full p-6 text-left flex justify-between items-center" onclick="toggleFAQ(4)">
                        <h3 class="text-lg font-semibold">What is your payment structure?</h3>
                        <i class="fas fa-chevron-down transform transition-transform" id="faq-icon-4"></i>
                    </button>
                    <div class="px-6 pb-6 hidden" id="faq-content-4">
                        <p class="text-gray-400">I typically work with a 50% upfront payment and 50% upon completion for smaller projects. For larger projects, I offer milestone-based payments. All payments are processed securely through PayPal, Stripe, or bank transfer.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-gray-800 rounded-xl border border-gray-700">
                    <button class="w-full p-6 text-left flex justify-between items-center" onclick="toggleFAQ(5)">
                        <h3 class="text-lg font-semibold">Can you work with my existing team?</h3>
                        <i class="fas fa-chevron-down transform transition-transform" id="faq-icon-5"></i>
                    </button>
                    <div class="px-6 pb-6 hidden" id="faq-content-5">
                        <p class="text-gray-400">Absolutely! I have extensive experience collaborating with development teams, designers, and project managers. I'm comfortable working with Git workflows, Agile methodologies, and various project management tools.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-black">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gray-900 p-8 rounded-xl border border-gray-800">
                <h3 class="text-3xl font-bold mb-4">Ready to Start Your Project?</h3>
                <p class="text-gray-400 mb-6">Let's discuss your requirements and create something amazing together. Get a free consultation and project estimate.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://calendly.com/younasdev/strategy-call" target="_blank" class="btn-primary px-8 py-3 rounded-full font-bold">
                        <i class="fas fa-calendar mr-2"></i> Schedule a Call
                    </a>
                    <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-3 rounded-full font-medium hover:bg-white hover:text-black transition-colors">
                        <i class="fas fa-envelope mr-2"></i> Send Message
                    </a>
                </div>
                <div class="mt-6 text-sm text-gray-400">
                    <i class="fas fa-clock mr-2"></i> Average response time: 2 hours
                </div>
            </div>
        </div>
    </section>

    @endsection
