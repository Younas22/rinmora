@extends('common.layout')
@section('content')

  <!-- ░░░ 1. HERO ░░░ -->
    <section id="home" class="bg-black" style="min-height:100vh;padding-top:80px;">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 items-center" style="min-height:calc(100vh - 80px);">

                <!-- ── LEFT: 9 cols ── -->
                <div class="lg:col-span-8 space-y-3 py-10 lg:py-0 lg:pr-12">

                    <!-- Badge -->
                    <div class="proof-badge w-fit">
                        <span class="w-2 h-2 rounded-full pulse-dot" style="background:#B1E78E;"></span>
                        Available for New Projects
                    </div>

                    <!-- Name + Tagline -->
                    <div>
                        <h1 class="text-white font-black" style="font-size:clamp(2.6rem,5vw,3.8rem);letter-spacing:-0.05em;line-height:1.02;margin-bottom:-5px;">
                            Younas Dev
                        </h1>
                        <p style="color:#B1E78E;font-size:.7rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;">
                            Travel Tech Expert &nbsp;·&nbsp; SaaS Founder &nbsp;·&nbsp; PHP & Laravel Developer
                        </p>
                    </div>

                    <!-- Bio -->
                    <div class="hero-bio space-y-2" style="font-size:.92rem;line-height:1.2;color:white;">
                        <p>
                            Younas Dev is a Pakistan-based Software Engineer, Travel Tech Expert, and SaaS founder with
                            <span style="color:#B1E78E;font-weight:600;">6+ years</span> of experience building revenue-driven digital systems.
                            Specializes in <span style="color:#B1E78E;font-weight:600;">high-converting travel booking platforms</span>,
                            scalable <span style="color:#B1E78E;font-weight:600;">Laravel</span> applications, and
                            <span style="color:#B1E78E;font-weight:600;">Local SEO</span> strategies that generate real
                            <span style="color:#B1E78E;font-weight:600;">bookings, leads, and business growth</span>.
                        </p>
                        <p>
                            Worked with <span style="color:#B1E78E;font-weight:600;">70+ clients</span> worldwide and generated over
                            <span style="color:#B1E78E;font-weight:600;">10,000+ leads</span>. Built
                            <a href="https://customernearme.com/" target="_blank" style="color:#B1E78E;font-weight:700;text-decoration:none;">CustomerNearMe</a>
                            — a SaaS used by <span style="color:#B1E78E;font-weight:600;">350+ freelancers</span> to find and close clients faster —
                            and authored the
                            <a href="https://younasphere34.gumroad.com/l/8-ClientsBlueprint" target="_blank" style="color:#B1E78E;font-weight:700;text-decoration:none;">8 Clients Blueprint</a>,
                            a practical system for consistent client acquisition.
                        </p>
                        <p>
                            Freelancing experience on
                            <a href="https://www.fiverr.com/" target="_blank" style="color:#B1E78E;font-weight:600;text-decoration:none;">Fiverr</a> and
                            <a href="https://www.upwork.com/" target="_blank" style="color:#B1E78E;font-weight:600;text-decoration:none;">Upwork</a>,
                            delivering projects in SaaS, travel tech, and automation.
                            Focused on building systems that generate
                            <span style="color:#B1E78E;font-weight:600;">clients, bookings, and revenue</span> — not just websites.
                        </p>
                    </div>

                    <!-- Companies -->
                    <div>
                        <p style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.14em;color:#374151;margin-bottom:8px;">Worked with</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="https://phptravels.com/" target="_blank"
                               style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:6px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:#9ca3af;font-size:.8rem;font-weight:500;text-decoration:none;transition:color .2s,border-color .2s;"
                               onmouseover="this.style.color='#B1E78E';this.style.borderColor='rgba(177,231,142,0.3)'" onmouseout="this.style.color='#9ca3af';this.style.borderColor='rgba(255,255,255,0.08)'">
                                <i class="fas fa-plane-departure" style="font-size:.65rem;color:#B1E78E;"></i> PHPTRAVELS
                            </a>
                            <a href="https://growthaccess.ae/" target="_blank"
                               style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:6px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:#9ca3af;font-size:.8rem;font-weight:500;text-decoration:none;transition:color .2s,border-color .2s;"
                               onmouseover="this.style.color='#B1E78E';this.style.borderColor='rgba(177,231,142,0.3)'" onmouseout="this.style.color='#9ca3af';this.style.borderColor='rgba(255,255,255,0.08)'">
                                <i class="fas fa-chart-line" style="font-size:.65rem;color:#B1E78E;"></i> Growth Access
                            </a>
                            <a href="https://avantcoretech.com/" target="_blank"
                               style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:6px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:#9ca3af;font-size:.8rem;font-weight:500;text-decoration:none;transition:color .2s,border-color .2s;"
                               onmouseover="this.style.color='#B1E78E';this.style.borderColor='rgba(177,231,142,0.3)'" onmouseout="this.style.color='#9ca3af';this.style.borderColor='rgba(255,255,255,0.08)'">
                                <i class="fas fa-microchip" style="font-size:.65rem;color:#B1E78E;"></i> Avantcore Tech
                            </a>
                        </div>
                    </div>

                    <!-- CTAs -->
                    <div class="flex flex-wrap gap-3">
                        <a href="https://wa.me/923460820722" target="_blank" class="btn-brand" style="padding:13px 24px;font-size:.93rem;min-width:170px;justify-content:center;">
                            <i class="fab fa-whatsapp text-lg"></i> Hire Me
                        </a>
                        <a href="https://calendly.com/younasdev/strategy-call" target="_blank" class="btn-outline" style="padding:11px 22px;font-size:.93rem;min-width:170px;justify-content:center;">
                            <i class="fas fa-calendar-check"></i> Book a Free Call
                        </a>
                    </div>

                    <!-- Social Links -->
                    <div class="flex flex-wrap items-center gap-y-2">
                        <span style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.14em;color:#374151;margin-right:10px;">Find me on</span>
                        <a href="https://www.linkedin.com/in/younasdev/" target="_blank" class="social-link"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                        <span style="color:#1f2937;padding:0 7px;">·</span>
                        <a href="https://x.com/YounasDev" target="_blank" class="social-link"><i class="fab fa-x-twitter"></i> Twitter</a>
                        <span style="color:#1f2937;padding:0 7px;">·</span>
                        <a href="https://www.facebook.com/YounasDev" target="_blank" class="social-link"><i class="fab fa-facebook-f"></i> Facebook</a>
                        <span style="color:#1f2937;padding:0 7px;">·</span>
                        <a href="https://www.youtube.com/@YounasDev" target="_blank" class="social-link"><i class="fab fa-youtube"></i> YouTube</a>
                        <span style="color:#1f2937;padding:0 7px;">·</span>
                        <a href="https://github.com/younas22" target="_blank" class="social-link"><i class="fab fa-github"></i> GitHub</a>
                    </div>

                    <!-- Stats -->
                    <div class="flex flex-wrap gap-0 pt-5 border-t" style="border-color:#111;">
                        <div class="text-center pr-5">
                            <div class="font-black text-white" style="font-size:1.4rem;line-height:1;">6+</div>
                            <div class="text-gray-600 mt-1" style="font-size:0.6rem;text-transform:uppercase;letter-spacing:.1em;">Years Exp</div>
                        </div>
                        <div class="w-px self-stretch mx-1" style="background:#111;"></div>
                        <div class="text-center px-5">
                            <div class="font-black text-white" style="font-size:1.4rem;line-height:1;">70+</div>
                            <div class="text-gray-600 mt-1" style="font-size:0.6rem;text-transform:uppercase;letter-spacing:.1em;">Clients</div>
                        </div>
                        <div class="w-px self-stretch mx-1" style="background:#111;"></div>
                        <div class="text-center px-5">
                            <div class="font-black text-white" style="font-size:1.4rem;line-height:1;">350+</div>
                            <div class="text-gray-600 mt-1" style="font-size:0.6rem;text-transform:uppercase;letter-spacing:.1em;">SaaS Users</div>
                        </div>
                        <div class="w-px self-stretch mx-1" style="background:#111;"></div>
                        <div class="text-center pl-5">
                            <div class="font-black" style="font-size:1.4rem;line-height:1;color:#B1E78E;">10K+</div>
                            <div class="text-gray-600 mt-1" style="font-size:0.6rem;text-transform:uppercase;letter-spacing:.1em;">Leads Generated</div>
                        </div>
                    </div>

                </div>

                <!-- ── RIGHT: 3 cols — Image ── -->
                <div class="lg:col-span-4 flex items-start justify-center lg:justify-end" style="margin-top:-80px;">
                    <div style="position:relative;width:100%;max-width:420px;">
                        <img src="{{ asset('public/assets/images/personal/hero.png') }}"
                             alt="Younas Dev — PHP Laravel & Travel Tech Developer"
                             style="width:100%;max-height:calc(100vh);object-fit:contain;object-position:top center;display:block;" />
                        <div style="position:absolute;bottom:0;left:0;right:0;height:180px;
                                    background:linear-gradient(to top,#000 0%,rgba(0,0,0,0.7) 40%,transparent 100%);
                                    pointer-events:none;"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Experience Section -->
    <section id="experience" class="py-10 bg-black border-t section-line">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-black mb-2">Professional Experience</h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-sm">My journey as a PHP/Laravel developer</p>
            </div>
            <div class="space-y-4">

                <!-- Self-Employed (Current) -->
                <div class="p-5 rounded-xl border card-hover" style="background:#111111;border-color:#222222;">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-white">Self-Employed Developer</h3>
                            <p class="text-gray-400 text-sm">Senior Laravel Developer · Jul 2024 – Present</p>
                        </div>
                        <span class="mt-2 md:mt-0 self-start px-3 py-0.5 rounded-full text-xs font-semibold" style="background:rgba(177,231,142,0.1);color:#B1E78E;border:1px solid rgba(177,231,142,0.2);">Current</span>
                    </div>
                    <ul class="space-y-1.5 text-gray-400 text-sm">
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Working independently on custom Laravel projects for international clients</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Developing AI-powered SaaS applications and API integrations</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Building e-commerce platforms and inventory management systems</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Providing consultation on web architecture and performance optimization</span></li>
                    </ul>
                </div>

                <!-- AVANTCORE -->
                <div class="p-5 rounded-xl border card-hover" style="background:#111111;border-color:#222222;">
                    <div class="mb-3">
                        <h3 class="text-lg font-bold text-white">AVANTCORE Technologies</h3>
                        <p class="text-gray-400 text-sm">Senior Laravel Developer · Jun 2024 – Jun 2025</p>
                    </div>
                    <ul class="space-y-1.5 text-gray-400 text-sm">
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Built an inventory management system using Amazon SP-API</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Developed CRM modules for attendance, salaries, and task management</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Collaborated with team members to ensure smooth project delivery</span></li>
                    </ul>
                </div>

                <!-- Growth Access -->
                <div class="p-5 rounded-xl border card-hover" style="background:#111111;border-color:#222222;">
                    <div class="mb-3">
                        <h3 class="text-lg font-bold text-white">Growth Access</h3>
                        <p class="text-gray-400 text-sm">PHP, Laravel Developer · Oct 2023 – Feb 2024</p>
                    </div>
                    <ul class="space-y-1.5 text-gray-400 text-sm">
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Built Contrafinder — a construction management system</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Worked on HighReturn Project as a Laravel Developer</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Developed FindTutor platform (TeachMe)</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Developed a Video Recording Editor & optimized image processing</span></li>
                    </ul>
                </div>

                <!-- Freelance Work -->
                <div class="p-5 rounded-xl border card-hover" style="background:#111111;border-color:#222222;">
                    <div class="mb-3">
                        <h3 class="text-lg font-bold text-white">Freelance Developer</h3>
                        <p class="text-gray-400 text-sm">Fiverr & Upwork · Mar 2022 – Sep 2023</p>
                    </div>
                    <ul class="space-y-1.5 text-gray-400 text-sm">
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Completed 30+ projects on Fiverr and Upwork with 5-star ratings</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Built custom web applications for clients in US, UK, and Australia</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Specialized in Laravel API development and third-party integrations</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Developed e-commerce solutions and booking management systems</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Maintained long-term client relationships and received repeat business</span></li>
                    </ul>
                </div>

                <!-- PHPTRAVELS -->
                <div class="p-5 rounded-xl border card-hover" style="background:#111111;border-color:#222222;">
                    <div class="mb-3">
                        <h3 class="text-lg font-bold text-white">PHPTRAVELS</h3>
                        <p class="text-gray-400 text-sm">PHP Developer · Jun 2019 – Feb 2022</p>
                    </div>
                    <ul class="space-y-1.5 text-gray-400 text-sm">
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Rebuilt the web-based booking portal with a team</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Integrated 6+ CRM, 3+ Payment, and 5+ Project Management Systems</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Refactored legacy code using OOP principles</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Implemented two-factor authentication for user login</span></li>
                        <li class="flex items-start gap-2"><i class="fas fa-check mt-0.5" style="color:#B1E78E;"></i><span>Secured SQL Injection vulnerabilities</span></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-10 bg-black border-t section-line">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-black mb-2">Featured Projects</h2>
                <p class="text-gray-400 text-sm">Some of my recent work</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php
                $projects = json_decode(file_get_contents('project.json'), true);
                foreach (array_slice($projects, 0, 3) as $project):
                ?>
                <a href="<?= url('project/' . urlencode(strtolower(str_replace(' ', '-', $project['title'])))); ?>"
                   class="rounded-xl overflow-hidden card-hover" style="background:#0d0d0d;border:1px solid #222222;">
                    <div class="h-36 bg-cover bg-center" style="background-image: url('{{ asset('public/assets/images/project/' . $project['image']) }}');"></div>
                    <div class="p-4">
                        <h3 class="text-base font-bold mb-1 text-white"><?= urlencode($project['title']) ?></h3>
                        <p class="text-gray-400 text-sm mb-3"><?= $project['short_detail'] ?></p>
                        <div class="flex flex-wrap gap-1.5">
                            <?php foreach ($project['tech_stack'] as $tech): ?>
                                <span class="text-white px-2 py-0.5 rounded text-xs" style="background:#1a1a1a;border:1px solid #333;"><?= $tech ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-8">
                <a href="{{ url('projects') }}" class="btn-outline" style="padding:10px 28px;font-size:.9rem;">
                    <i class="fas fa-briefcase"></i> View All Projects
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 bg-black border-t section-line">
        <div class="max-w-xl mx-auto px-6 text-center space-y-6">
            <h2 class="text-3xl md:text-4xl font-black text-white">Ready to Work Together?</h2>
            <p class="text-gray-400">Message me — I reply fast and I'm always ready to help</p>

            <div class="bg-black border border-gray-800 rounded-2xl p-6 space-y-3">
                <a href="https://wa.me/923460820722" target="_blank" class="btn-brand w-full" style="padding:14px 28px;font-size:1rem;justify-content:center;">
                    <i class="fab fa-whatsapp text-lg"></i>
                    Hire Me — +92 346 0820722
                </a>
                <a href="mailto:hello@younasdev.com" class="btn-white w-full" style="padding:12px 28px;font-size:.9rem;justify-content:center;">
                    <i class="fas fa-envelope"></i>
                    hello@younasdev.com
                </a>
                <p class="text-gray-600 text-xs">6+ Years · 70+ Clients · Fast Response</p>
            </div>

            <div class="flex flex-wrap justify-center gap-2">
                <a href="https://customernearme.com/" target="_blank"
                   class="text-xs font-medium px-3 py-1.5 rounded-full border border-gray-700 text-gray-400 hover:text-white hover:border-gray-500 transition-colors">
                    <i class="fas fa-location-dot mr-1"></i> CustomerNearMe
                </a>
                <a href="https://younasphere34.gumroad.com/l/8-ClientsBlueprint" target="_blank"
                   class="text-xs font-medium px-3 py-1.5 rounded-full border border-gray-700 text-gray-400 hover:text-white hover:border-gray-500 transition-colors">
                    <i class="fas fa-book-open mr-1"></i> Free eBook
                </a>
                <a href="{{ url('projects') }}"
                   class="text-xs font-medium px-3 py-1.5 rounded-full border border-gray-700 text-gray-400 hover:text-white hover:border-gray-500 transition-colors">
                    <i class="fas fa-laptop-code mr-1"></i> Projects
                </a>
                <a href="{{ route('blog') }}"
                   class="text-xs font-medium px-3 py-1.5 rounded-full border border-gray-700 text-gray-400 hover:text-white hover:border-gray-500 transition-colors">
                    <i class="fas fa-pen-nib mr-1"></i> Blog
                </a>
            </div>
        </div>
    </section>

@endsection
