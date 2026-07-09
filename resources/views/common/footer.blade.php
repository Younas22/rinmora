
    <!-- FOOTER -->
    <footer class="bg-black border-t section-line">
        <div class="max-w-6xl mx-auto px-6 py-10">
            <div class="grid lg:grid-cols-3 gap-8 mb-8">

                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ asset('public/assets/images/personal/logo.png') }}"
                             alt="Younas Dev" class="h-9 w-9 rounded-lg object-cover" />
                        <div>
                            <div class="font-bold text-white">Younas Dev</div>
                            <div class="text-xs text-gray-500">PHP Laravel Developer</div>
                        </div>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        6+ years building travel websites, running a Local SEO agency, and creating digital products. 70+ happy clients worldwide.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-3 text-xs uppercase tracking-wider">Quick Links</h4>
                    <ul class="space-y-1.5 text-sm">
                        <li><a href="https://customernearme.com/" target="_blank" class="text-gray-500 hover:text-white transition-colors">CustomerNearMe SaaS</a></li>
                        <li><a href="https://younasphere34.gumroad.com/l/8-ClientsBlueprint" target="_blank" class="text-gray-500 hover:text-white transition-colors">8 Clients Blueprint eBook</a></li>
                        <li><a href="{{route('blog')}}" class="text-gray-500 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="{{route('projects')}}" class="text-gray-500 hover:text-white transition-colors">Projects</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-3 text-xs uppercase tracking-wider">Contact</h4>
                    <div class="space-y-2">
                        <a href="https://wa.me/923460820722" target="_blank"
                           class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors text-sm">
                            <i class="fab fa-whatsapp" style="color:#25D366;"></i> +92 346 0820722
                        </a>
                        <a href="mailto:hello@younasdev.com"
                           class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors text-sm">
                            <i class="fas fa-envelope" style="color:#B1E78E;"></i> hello@younasdev.com
                        </a>
                        <div class="flex gap-2 pt-1">
                            <a href="https://www.linkedin.com/in/younasdev/" target="_blank"
                               class="w-7 h-7 bg-white rounded-lg flex items-center justify-center hover:opacity-80 transition-opacity">
                                <i class="fab fa-linkedin text-blue-700 text-xs"></i>
                            </a>
                            <a href="https://x.com/YounasDev" target="_blank"
                               class="w-7 h-7 bg-white rounded-lg flex items-center justify-center hover:opacity-80 transition-opacity">
                                <i class="fab fa-x-twitter text-black text-xs"></i>
                            </a>
                            <a href="https://github.com/younas22" target="_blank"
                               class="w-7 h-7 bg-white rounded-lg flex items-center justify-center hover:opacity-80 transition-opacity">
                                <i class="fab fa-github text-gray-900 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="border-t border-gray-900 pt-6 flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-gray-600">
                <p>&copy; 2025 <span class="text-white font-semibold">Younas Dev</span> — PHP Laravel Developer</p>
                <div class="flex gap-4">
                    <a href="{{route('blog')}}" class="hover:text-white transition-colors">Blog</a>
                    <a href="{{route('projects')}}" class="hover:text-white transition-colors">Projects</a>
                    <a href="{{ route('contact') }}" class="font-bold" style="color:#B1E78E;">Hire Me</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', function () {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });

        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.style.opacity = '1';
                    e.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.08 });

        document.querySelectorAll('section').forEach(s => {
            s.style.opacity = '0';
            s.style.transform = 'translateY(20px)';
            s.style.transition = 'opacity .5s ease, transform .5s ease';
            io.observe(s);
        });

        document.querySelector('#home').style.opacity = '1';
        document.querySelector('#home').style.transform = 'translateY(0)';
    </script>
</body>
</html>
