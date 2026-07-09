@extends('common.layout')
@section('content')

<style>
    .chapter-sep {
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, rgba(177,231,142,0.10) 35%, rgba(177,231,142,0.10) 65%, transparent 100%);
    }
    .chapter-label {
        font-size: 0.62rem; font-weight: 700; letter-spacing: 0.22em;
        text-transform: uppercase; color: rgba(177,231,142,0.4);
        display: block; margin-bottom: 8px;
    }
    .pd-card {
        background: #0a0a0a; border: 1px solid #1a1a1a; border-radius: 16px;
        padding: 28px; transition: border-color .25s;
    }
    .pd-card:hover { border-color: rgba(177,231,142,0.18); }
    .tech-pill {
        display: inline-flex; align-items: center;
        background: rgba(177,231,142,0.08); border: 1px solid rgba(177,231,142,0.20);
        color: #B1E78E; padding: 4px 13px; border-radius: 100px;
        font-size: 0.73rem; font-weight: 600; letter-spacing: .03em;
    }
    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        color: #6b7280; font-size: .85rem; font-weight: 500; text-decoration: none;
        transition: color .2s;
    }
    .back-link:hover { color: #B1E78E; }
    .feature-item {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 10px 13px; border-radius: 9px;
        background: rgba(255,255,255,0.025); border: 1px solid rgba(255,255,255,0.055);
        font-size: 0.875rem; color: #9ca3af; line-height: 1.55;
        transition: background .2s, border-color .2s, color .2s;
    }
    .feature-item:hover { background: rgba(177,231,142,0.04); border-color: rgba(177,231,142,0.16); color: #d1d5db; }
    .detail-row { padding: 14px 0; border-bottom: 1px solid #111; }
    .detail-row:last-child { border-bottom: none; padding-bottom: 0; }
    .detail-row:first-child { padding-top: 0; }
    .detail-label { font-size: .60rem; font-weight: 700; letter-spacing: .20em; text-transform: uppercase; color: rgba(177,231,142,0.45); margin-bottom: 4px; }
    .detail-value { font-size: .9rem; color: #9ca3af; line-height: 1.6; }
    .section-heading { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .12em; color: rgba(177,231,142,0.5); margin-bottom: 16px; }
</style>

<section class="bg-black" style="padding:100px 0 80px;">
    <div class="max-w-5xl mx-auto px-6">

        <!-- Back link -->
        <div class="mb-10">
            <a href="{{ url('projects') }}" class="back-link">
                <i class="fas fa-arrow-left" style="font-size:.72rem;"></i>
                Back to Projects
            </a>
        </div>

        <!-- Page Header -->
        <div class="mb-12">
            <span class="chapter-label">Case Study</span>
            <h1 class="text-white font-black leading-tight" style="font-size:clamp(2rem,4vw,2.8rem);letter-spacing:-0.03em;margin-bottom:12px;">
                <?= htmlspecialchars($project['title']) ?>
            </h1>
            <p style="font-size:1.02rem;line-height:1.75;color:#9ca3af;max-width:680px;">
                <?= htmlspecialchars($project['short_detail']) ?>
            </p>
        </div>

        <div class="chapter-sep mb-10"></div>

        <div class="grid lg:grid-cols-2 gap-8 items-start">

            <!-- Left column -->
            <div class="space-y-6">

                <!-- Tech Stack + CTA -->
                <div class="pd-card">
                    <div class="section-heading"><i class="fas fa-layer-group mr-2"></i>Tech Stack</div>
                    <div class="flex flex-wrap gap-2 mb-7">
                        <?php foreach ($project['tech_stack'] as $tech): ?>
                            <span class="tech-pill"><?= htmlspecialchars($tech) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank"
                       class="btn-brand" style="padding:12px 22px;font-size:.92rem;">
                        <i class="fas fa-external-link-alt"></i> Visit Live Project
                    </a>
                </div>

                <!-- Project Details -->
                <div class="pd-card">
                    <div class="section-heading"><i class="fas fa-info-circle mr-2"></i>Project Details</div>
                    <div class="detail-row">
                        <div class="detail-label">Client</div>
                        <div class="detail-value"><?= htmlspecialchars($project['client']) ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">My Role</div>
                        <div class="detail-value"><?= htmlspecialchars($project['role']) ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Technologies Used</div>
                        <div class="detail-value"><?= htmlspecialchars(implode(', ', $project['tech_stack'])) ?></div>
                    </div>
                </div>

            </div>

            <!-- Right column: Description + Features -->
            <div class="pd-card" style="height:fit-content;">
                <div class="section-heading"><i class="fas fa-file-alt mr-2"></i>Project Description</div>
                <p style="font-size:.9rem;line-height:1.80;color:#9ca3af;margin-bottom:24px;">
                    <?= htmlspecialchars($project['description']) ?>
                </p>
                <div class="section-heading"><i class="fas fa-check-double mr-2"></i>Key Features</div>
                <div class="space-y-2">
                    <?php foreach ($project['features'] as $feature): ?>
                        <div class="feature-item">
                            <i class="fas fa-check-circle" style="color:#B1E78E;flex-shrink:0;margin-top:2px;"></i>
                            <?= htmlspecialchars($feature) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <!-- Screenshot -->
        <div class="mt-12">
            <div class="chapter-sep mb-10"></div>
            <span class="chapter-label">Project Screenshot</span>
            <div class="pd-card" style="padding:20px;">
                <img src="{{ asset('public/assets/images/project/' . $project['image']) }}"
                     alt="<?= htmlspecialchars($project['title']) ?>"
                     class="rounded-xl w-full">
                <p class="text-center mt-3" style="font-size:.8rem;color:#4b5563;">
                    <?= htmlspecialchars($project['title']) ?> — Live Preview
                </p>
            </div>
        </div>

        <!-- Bottom CTA -->
        <div class="mt-14 text-center">
            <a href="{{ url('projects') }}" class="btn-outline" style="padding:13px 32px;font-size:.92rem;border-radius:100px;">
                <i class="fas fa-briefcase"></i> View All Projects
            </a>
        </div>

    </div>
</section>

@endsection
