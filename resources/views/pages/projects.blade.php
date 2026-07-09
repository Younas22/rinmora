@extends('common.layout')
@section('content')

    <!-- All Projects Page -->
    <section id="all-projects" class="py-10 bg-black pt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl md:text-3xl font-bold mb-2">My Projects</h1>
                <p class="text-sm text-gray-400 max-w-2xl mx-auto">A collection of my recent work and case studies</p>
            </div>

            <!-- Projects Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php
                $projects = json_decode(file_get_contents('project.json'), true);
                foreach ($projects as $project):
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
        </div>
    </section>

@endsection
