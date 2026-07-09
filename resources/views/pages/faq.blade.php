@extends('common.layout')
@section('content')

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

@endsection