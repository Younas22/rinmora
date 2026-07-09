    <!-- FLOATING WHATSAPP -->
    <a href="https://wa.me/923460820722" target="_blank" class="wa-float" title="WhatsApp — Message Me Now">
        <i class="fab fa-whatsapp text-white text-2xl"></i>
    </a>


<!-- NAVBAR -->
    <nav class="fixed top-0 w-full z-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-center justify-end py-3">
                <div class="hidden lg:flex items-center gap-6">
                    <a href="{{url('/')}}" class="text-white hover:text-brand transition-colors text-sm font-medium">Home</a>
                    <a href="{{route('about')}}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">About</a>
                    <a href="{{ route('projects') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">Projects</a>
                    <a href="{{route('blog')}}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">Blog</a>
                    <a href="https://calendly.com/younasdev/strategy-call" target="_blank"
                       style="background:#B1E78E;color:#000;font-weight:700;border-radius:8px;padding:8px 18px;font-size:.85rem;display:flex;align-items:center;gap:6px;text-decoration:none;transition:opacity .2s;"
                       onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                        <i class="fas fa-calendar"></i> Book a Call
                    </a>
                </div>

                <button id="mobile-menu-btn" class="lg:hidden p-2 text-white">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <div id="mobile-menu" class="lg:hidden hidden pb-4 border-t border-gray-800">
                <div class="flex flex-col gap-2 pt-4">
                    <a href="{{url('/')}}" class="text-white px-2 py-2 text-sm">Home</a>
                    <a href="{{route('about')}}" class="text-gray-400 px-2 py-2 text-sm">About</a>
                    <a href="{{ route('projects') }}" class="text-gray-400 px-2 py-2 text-sm">Projects</a>
                    <a href="{{route('blog')}}" class="text-gray-400 px-2 py-2 text-sm">Blog</a>
                    <a href="https://calendly.com/younasdev/strategy-call" target="_blank"
                       class="btn-brand mt-2" style="border-radius:8px;padding:10px 18px;font-size:.875rem;">
                        <i class="fas fa-calendar"></i> Book a Call
                    </a>
                </div>
            </div>
        </div>
    </nav>