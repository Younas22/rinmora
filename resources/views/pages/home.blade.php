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
                            PHP Laravel Developer &nbsp;·&nbsp; Travel Tech Expert &nbsp;·&nbsp; SaaS
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

 
<!-- ░░░ 4. CUSTOMERNEARME STORY ░░░ -->
<section class="py-16 border-t section-line" style="background:#060606;">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-12">

            <div class="flex-1 space-y-5">

                <div class="proof-badge w-fit">
                    <span class="w-2 h-2 rounded-full pulse-dot" style="background:#B1E78E;"></span>
                    My Journey · Why I Built This
                </div>

                <h2 class="text-3xl md:text-4xl font-black text-white leading-tight">
                    I Was Tired of Chasing Clients.<br>
                    <span style="color:#B1E78E;">So I Built a System Instead.</span>
                </h2>

                <p class="text-gray-400 leading-relaxed" style="font-size:.95rem;">
                    When I started freelancing, the hardest part wasn’t coding — it was finding clients.
                    Cold emails, random DMs, and freelance marketplaces were unpredictable and exhausting.
                </p>

                <p class="text-gray-400 leading-relaxed" style="font-size:.95rem;">
                    Every day I saw thousands of real businesses on Google Maps actively running — gyms, restaurants, agencies — all of them needing websites, SEO, and automation.
                    But there was no simple way to connect freelancers with these businesses.
                </p>

                <p class="text-gray-400 leading-relaxed" style="font-size:.95rem;">
                    That’s when I started building <span style="color:#B1E78E;font-weight:600;">CustomerNearMe</span>.
                    Not as a tool… but as a system to remove uncertainty from client hunting.
                </p>

                <div class="grid grid-cols-3 gap-3">

                    <div class="text-center rounded-xl p-4 border border-gray-800" style="background:#0a0a0a;">
                        <div class="text-2xl font-black" style="color:#B1E78E;">350+</div>
                        <div class="text-xs text-gray-500 mt-1">Freelancers Using It</div>
                    </div>

                    <div class="text-center rounded-xl p-4 border border-gray-800" style="background:#0a0a0a;">
                        <div class="text-2xl font-black text-white">10K+</div>
                        <div class="text-xs text-gray-500 mt-1">Real Leads Found</div>
                    </div>

                    <div class="text-center rounded-xl p-4 border border-gray-800" style="background:#0a0a0a;">
                        <div class="text-2xl font-black" style="color:#B1E78E;">Live</div>
                        <div class="text-xs text-gray-500 mt-1">Evolving System</div>
                    </div>

                </div>

                <div class="space-y-2 text-sm text-gray-400">
                    <div class="flex items-center gap-2"><i class="fas fa-check-circle" style="color:#B1E78E;"></i> Built from my own struggle as a freelancer</div>
                    <div class="flex items-center gap-2"><i class="fas fa-check-circle" style="color:#B1E78E;"></i> Replaces guesswork with real business data</div>
                    <div class="flex items-center gap-2"><i class="fas fa-check-circle" style="color:#B1E78E;"></i> Helps you find clients who actually need you</div>
                    <div class="flex items-center gap-2"><i class="fas fa-check-circle" style="color:#B1E78E;"></i> Designed for speed, simplicity, and results</div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="https://customernearme.com/" target="_blank" class="btn-brand" style="padding:12px 24px;font-size:.95rem;">
                        <i class="fas fa-rocket"></i> Try the System I Built
                    </a>

                    <a href="https://wa.me/923460820722?text=Tell%20me%20your%20story%20behind%20CustomerNearMe" target="_blank" class="btn-ghost" style="padding:11px 22px;font-size:.92rem;">
                        <i class="fab fa-whatsapp"></i> Ask Me Why I Built It
                    </a>
                </div>

            </div>

            <!-- Product Card -->
            <div class="flex-shrink-0 w-full lg:w-96">
                <div class="rounded-2xl p-6 space-y-5 glow-green"
                     style="background:#0a0a0a;border:1px solid rgba(177,231,142,0.22);">

                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                             style="background:rgba(177,231,142,0.12);">
                            <i class="fas fa-location-dot text-2xl" style="color:#B1E78E;"></i>
                        </div>
                        <div>
                            <div class="text-white font-bold text-lg">CustomerNearMe</div>
                            <div class="text-xs text-gray-500">From Problem → Solution</div>
                        </div>
                    </div>

                    <div class="space-y-3">

                        <div class="rounded-xl p-3 flex items-center gap-3"
                             style="background:rgba(177,231,142,0.06);border:1px solid rgba(177,231,142,0.1);">
                            <i class="fas fa-brain" style="color:#B1E78E;"></i>
                            <span class="text-sm text-gray-300">Built from real freelancer struggle</span>
                        </div>

                        <div class="rounded-xl p-3 flex items-center gap-3"
                             style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);">
                            <i class="fas fa-globe" style="color:#B1E78E;"></i>
                            <span class="text-sm text-gray-300">Connects you with real businesses</span>
                        </div>

                        <div class="rounded-xl p-3 flex items-center gap-3"
                             style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);">
                            <i class="fas fa-bolt" style="color:#B1E78E;"></i>
                            <span class="text-sm text-gray-300">Turns effort into predictable clients</span>
                        </div>

                    </div>

                    <div class="border-t border-gray-800 pt-4 flex items-center justify-between text-xs text-gray-500">
                        <span>Built by Younas Dev</span>
                        <span class="font-bold px-2 py-0.5 rounded-full"
                              style="background:rgba(177,231,142,0.1);color:#B1E78E;">
                            Live SaaS
                        </span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- ░░░ 5. 8 CLIENTs BLUEPRINT (STORY VERSION) ░░░ -->
<section class="py-16 bg-black border-t section-line">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col lg:flex-row-reverse items-center gap-12">

            <div class="flex-1 space-y-5">

                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold"
                     style="background:rgba(177,231,142,0.1);color:#B1E78E;border:1px solid rgba(177,231,142,0.25);">
                    <i class="fas fa-book text-xs" style="color:#B1E78E;"></i> My Personal System · Built From Failure
                </div>

                <h2 class="text-3xl md:text-4xl font-black text-white leading-tight">
                    I Was Struggling to Get Clients…<br>
                    <span style="color:#B1E78E;">Until I Built This System</span>
                </h2>

                <p class="text-gray-400 leading-relaxed" style="font-size:.95rem;">
                    When I lost my job in 2022, I thought freelancing would be easy.
                    I joined Fiverr, Upwork, sent proposals… but nothing worked consistently.
                </p>

                <p class="text-gray-400 leading-relaxed" style="font-size:.95rem;">
                    The problem was simple — I didn’t have a system.
                    So I spent months testing, failing, and analyzing what actually makes clients respond.
                    That’s how I discovered a repeatable method to land clients without guessing.
                </p>

                <p class="text-gray-400 leading-relaxed" style="font-size:.95rem;">
                    I turned that experience into something simple — the
                    <span style="color:#B1E78E;font-weight:600;">8 Clients Blueprint</span>.
                    A practical system anyone can follow, even with zero experience.
                </p>

                <div class="grid grid-cols-3 gap-3">

                    <div class="text-center rounded-xl p-4 border border-gray-800" style="background:#0a0a0a;">
                        <div class="text-2xl font-black text-white">300+</div>
                        <div class="text-xs text-gray-500 mt-1">Freelancers Using It</div>
                    </div>

                    <div class="text-center rounded-xl p-4 border border-gray-800" style="background:#0a0a0a;">
                        <div class="text-2xl font-black text-white">50+</div>
                        <div class="text-xs text-gray-500 mt-1">Real Reviews</div>
                    </div>

                    <div class="text-center rounded-xl p-4 border border-gray-800" style="background:#0a0a0a;">
                        <div class="text-2xl font-black" style="color:#B1E78E;">5.0</div>
                        <div class="text-xs text-gray-500 mt-1">Rating</div>
                    </div>

                </div>

                <div class="space-y-2 text-sm text-gray-400">
                    <div class="flex items-center gap-2"><i class="fas fa-check-circle" style="color:#B1E78E;"></i> Built from real freelancing experience (not theory)</div>
                    <div class="flex items-center gap-2"><i class="fas fa-check-circle" style="color:#B1E78E;"></i> Works for Fiverr, Upwork & direct clients</div>
                    <div class="flex items-center gap-2"><i class="fas fa-check-circle" style="color:#B1E78E;"></i> Simple system anyone can understand & apply</div>
                    <div class="flex items-center gap-2"><i class="fas fa-check-circle" style="color:#B1E78E;"></i> Focused on psychology, not spam or automation</div>
                </div>

                <a href="https://younasphere34.gumroad.com/l/8-ClientsBlueprint" target="_blank"
                   class="btn-brand inline-flex" style="padding:13px 26px;font-size:.95rem;">
                    <i class="fas fa-bolt"></i> Get My Exact Client System
                </a>

            </div>

            <!-- Product Card -->
            <div class="flex-shrink-0 w-full lg:w-80">
                <div class="rounded-2xl p-6 space-y-4"
                     style="background:#0a0a0a;border:1px solid rgba(177,231,142,0.18);">

                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                             style="background:rgba(177,231,142,0.12);">
                            <i class="fas fa-book-open text-2xl" style="color:#B1E78E;"></i>
                        </div>
                        <div>
                            <div class="text-white font-bold">8 Clients Blueprint</div>
                            <div class="text-xs text-gray-500">From Struggle → System</div>
                        </div>
                    </div>

                    <div class="space-y-2">

                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <i class="fas fa-fire text-xs" style="color:#B1E78E;"></i> Built after real freelancing failure
                        </div>

                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <i class="fas fa-envelope text-xs" style="color:#B1E78E;"></i> Copy-paste outreach templates
                        </div>

                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <i class="fas fa-brain text-xs" style="color:#B1E78E;"></i> Psychology-based client approach
                        </div>

                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <i class="fas fa-users text-xs" style="color:#B1E78E;"></i> Used by 300+ freelancers globally
                        </div>

                    </div>

                    <div class="border-t border-gray-800 pt-3 flex items-center justify-between">
                        <span class="text-xs text-gray-500">Available on Gumroad</span>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full"
                              style="background:rgba(177,231,142,0.1);color:#B1E78E;">
                            SYSTEM
                        </span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>


    <!-- ░░░ SOCIAL FOLLOW ░░░ -->
    <section class="py-12 bg-black border-t section-line">
        <div class="max-w-2xl mx-auto px-6 text-center space-y-6">
            <div>
                <h2 class="text-2xl font-black text-white mb-2">Follow My Journey</h2>
                <p class="text-gray-500 text-sm">I share tips on PHP, AI tools, freelancing &amp; client hunting — every week</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="https://www.youtube.com/@YounasDev" target="_blank"
                   class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-800 hover:border-red-500 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background:rgba(255,0,0,0.1);">
                        <i class="fab fa-youtube text-xl text-red-500"></i>
                    </div>
                    <div class="text-white font-semibold text-xs">YouTube</div>
                    <div class="text-gray-600 text-xs">Subscribe</div>
                </a>
                <a href="https://www.facebook.com/YounasDev" target="_blank"
                   class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-800 hover:border-blue-500 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background:rgba(59,130,246,0.1);">
                        <i class="fab fa-facebook text-xl text-blue-500"></i>
                    </div>
                    <div class="text-white font-semibold text-xs">Facebook</div>
                    <div class="text-gray-600 text-xs">Follow</div>
                </a>
                <a href="https://www.linkedin.com/in/younasdev/" target="_blank"
                   class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-800 hover:border-blue-400 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background:rgba(10,102,194,0.1);">
                        <i class="fab fa-linkedin text-xl text-blue-400"></i>
                    </div>
                    <div class="text-white font-semibold text-xs">LinkedIn</div>
                    <div class="text-gray-600 text-xs">Connect</div>
                </a>
                <a href="https://x.com/YounasDev" target="_blank"
                   class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-800 hover:border-white transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background:rgba(255,255,255,0.06);">
                        <i class="fab fa-x-twitter text-xl text-white"></i>
                    </div>
                    <div class="text-white font-semibold text-xs">X (Twitter)</div>
                    <div class="text-gray-600 text-xs">Follow</div>
                </a>
            </div>
        </div>
    </section>

    <!-- ░░░ 7. FINAL CTA ░░░ -->
    <section class="py-20 border-t section-line" style="background:#060606;">
        <div class="max-w-2xl mx-auto px-6 text-center space-y-6">

            <div class="proof-badge mx-auto w-fit">
                <span class="w-2 h-2 rounded-full pulse-dot" style="background:#B1E78E;"></span>
                Taking New Projects — Limited Spots
            </div>

            <h2 class="font-black text-white leading-tight" style="font-size:clamp(2rem,5vw,2.8rem);letter-spacing:-0.02em;">
                Ready to Get Clients,<br>
                Rank on Google, or<br>
                <span style="color:#B1E78E;">Build Something Real?</span>
            </h2>

            <p class="text-gray-400 text-sm max-w-sm mx-auto">
                Message me now. I reply fast. If it fits, we start within 48 hours. No long proposals. No wasted time.
            </p>

            <div class="rounded-2xl p-6 space-y-3 glow-green" style="background:#0a0a0a;border:1px solid rgba(177,231,142,0.2);">
                <a href="https://wa.me/923460820722" target="_blank"
                   class="btn-brand w-full" style="padding:15px 28px;font-size:1rem;justify-content:center;border-radius:12px;">
                    <i class="fab fa-whatsapp text-xl"></i>
                    Message Me — +92 346 0820722
                </a>
                <a href="https://calendly.com/younasdev/strategy-call" target="_blank"
                   class="btn-outline w-full" style="padding:12px 28px;font-size:.92rem;justify-content:center;border-radius:12px;">
                    <i class="fas fa-calendar-check"></i>
                    Book a Free Strategy Call
                </a>
                <a href="mailto:hello@younasdev.com"
                   class="btn-ghost w-full" style="padding:12px 28px;font-size:.88rem;justify-content:center;border-radius:12px;">
                    <i class="fas fa-envelope"></i>
                    hello@younasdev.com
                </a>
                <p class="text-gray-600 text-xs pt-1">6+ Years · 70+ Clients · Replies in under 12 hours</p>
            </div>

            <div class="flex flex-wrap justify-center gap-2 pt-2">
                <a href="https://customernearme.com/" target="_blank"
                   class="text-xs font-medium px-3 py-1.5 rounded-full border border-gray-700 text-gray-400 hover:text-white hover:border-gray-500 transition-colors">
                    <i class="fas fa-location-dot mr-1"></i> CustomerNearMe
                </a>
                <a href="https://younasphere34.gumroad.com/l/8-ClientsBlueprint" target="_blank"
                   class="text-xs font-medium px-3 py-1.5 rounded-full border border-gray-700 text-gray-400 hover:text-white hover:border-gray-500 transition-colors">
                    <i class="fas fa-book-open mr-1"></i> 8 Clients Blueprint
                </a>
                <a href="{{route('about')}}"
                   class="text-xs font-medium px-3 py-1.5 rounded-full border border-gray-700 text-gray-400 hover:text-white hover:border-gray-500 transition-colors">
                    <i class="fas fa-user mr-1"></i> About Me
                </a>
                <a href="{{route('blog')}}"
                   class="text-xs font-medium px-3 py-1.5 rounded-full border border-gray-700 text-gray-400 hover:text-white hover:border-gray-500 transition-colors">
                    <i class="fas fa-pen-nib mr-1"></i> Blog
                </a>
            </div>

        </div>
    </section>
@endsection