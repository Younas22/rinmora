@extends('common.layout')
@section('content')

    <!-- Contact Page -->
    <section class="py-10 bg-black pt-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold mb-3" style="background:rgba(177,231,142,0.1);color:#B1E78E;border:1px solid rgba(177,231,142,0.2);">
                    <span class="w-2 h-2 rounded-full inline-block animate-pulse" style="background:#B1E78E;"></span>
                    Available for new projects
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-white mb-2">Get In Touch</h1>
                <p class="text-sm text-gray-400">Ready to discuss your project? Reach out — I reply fast.</p>
            </div>

            <!-- Primary CTAs -->
            <div class="grid sm:grid-cols-2 gap-3 mb-6">
                <a href="https://wa.me/923460820722" target="_blank" class="btn-brand w-full justify-center" style="padding:14px 20px;font-size:.95rem;">
                    <i class="fab fa-whatsapp text-lg"></i>
                    Chat on WhatsApp
                </a>
                <a href="https://calendly.com/younasdev/strategy-call" target="_blank" class="btn-outline w-full justify-center" style="padding:14px 20px;font-size:.95rem;">
                    <i class="fas fa-calendar"></i>
                    Book a Free Call
                </a>
            </div>

            <!-- Contact Details Card -->
            <div class="rounded-xl p-5 mb-4" style="background:#111111;border:1px solid #222222;">
                <h3 class="text-base font-bold text-white mb-4">Contact Information</h3>
                <div class="space-y-3">

                    <a href="https://wa.me/923460820722" target="_blank"
                       class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors group">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(37,211,102,0.12);">
                            <i class="fab fa-whatsapp text-sm" style="color:#25D366;"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">WhatsApp</div>
                            <div class="text-sm font-medium text-white group-hover:text-brand transition-colors">+92 346 0820722</div>
                        </div>
                    </a>

                    <a href="mailto:hello@younasdev.com"
                       class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors group">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(177,231,142,0.12);">
                            <i class="fas fa-envelope text-sm" style="color:#B1E78E;"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Email</div>
                            <div class="text-sm font-medium text-white group-hover:text-brand transition-colors">hello@younasdev.com</div>
                        </div>
                    </a>

                    <div class="flex items-center gap-3 p-3 rounded-lg">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.07);">
                            <i class="fas fa-map-marker-alt text-sm text-white"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Location</div>
                            <div class="text-sm font-medium text-white">Lahore, Pakistan</div>
                        </div>
                    </div>

                    <a href="https://younasdev.com" target="_blank"
                       class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors group">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.07);">
                            <i class="fas fa-globe text-sm text-white"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Website</div>
                            <div class="text-sm font-medium text-white group-hover:text-brand transition-colors">younasdev.com</div>
                        </div>
                    </a>

                </div>
            </div>

            <!-- Social Links Card -->
            <div class="rounded-xl p-5 mb-4" style="background:#111111;border:1px solid #222222;">
                <h3 class="text-base font-bold text-white mb-4">Connect With Me</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

                    <a href="https://www.linkedin.com/in/younasdev/" target="_blank"
                       class="flex flex-col items-center gap-2 p-3 rounded-lg border border-gray-800 hover:border-blue-500 transition-all hover:-translate-y-0.5 group">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(59,130,246,0.1);">
                            <i class="fab fa-linkedin text-blue-500"></i>
                        </div>
                        <span class="text-xs text-gray-400 group-hover:text-white transition-colors">LinkedIn</span>
                    </a>

                    <a href="https://github.com/Younas22" target="_blank"
                       class="flex flex-col items-center gap-2 p-3 rounded-lg border border-gray-800 hover:border-white transition-all hover:-translate-y-0.5 group">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(255,255,255,0.07);">
                            <i class="fab fa-github text-white"></i>
                        </div>
                        <span class="text-xs text-gray-400 group-hover:text-white transition-colors">GitHub</span>
                    </a>

                    <a href="https://x.com/YounasDev" target="_blank"
                       class="flex flex-col items-center gap-2 p-3 rounded-lg border border-gray-800 hover:border-white transition-all hover:-translate-y-0.5 group">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(255,255,255,0.07);">
                            <i class="fab fa-x-twitter text-white"></i>
                        </div>
                        <span class="text-xs text-gray-400 group-hover:text-white transition-colors">X (Twitter)</span>
                    </a>

                    <a href="https://www.youtube.com/@YounasDev" target="_blank"
                       class="flex flex-col items-center gap-2 p-3 rounded-lg border border-gray-800 hover:border-red-500 transition-all hover:-translate-y-0.5 group">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(255,0,0,0.1);">
                            <i class="fab fa-youtube text-red-500"></i>
                        </div>
                        <span class="text-xs text-gray-400 group-hover:text-white transition-colors">YouTube</span>
                    </a>

                </div>
            </div>

            <!-- Response time note -->
            <div class="text-center">
                <p class="text-xs text-gray-600">
                    <i class="fas fa-clock mr-1"></i>
                    Typically responds within a few hours · 6+ Years · 70+ Clients
                </p>
            </div>

        </div>
    </section>

@endsection
