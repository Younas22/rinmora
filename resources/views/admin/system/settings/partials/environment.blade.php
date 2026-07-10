<div id="panel-environment" class="tab-panel space-y-6 {{ request('tab') !== 'environment' ? 'hidden' : '' }}">
    <form method="POST" action="{{ route('admin.system.settings.environment') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PUT')

        <h2 class="font-bold text-sm mb-1">Environment Mode</h2>
        <p class="text-black/40 text-xs mb-4">Switch which set of URLs below is currently active.</p>
        <div class="grid grid-cols-2 gap-3 mb-6">
            <label class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 cursor-pointer transition {{ ($environment['mode'] ?? 'development') === 'development' ? 'border-primary bg-primary/10' : 'border-black/10' }}">
                <input type="radio" name="mode" value="development" class="accent-primary" @checked(($environment['mode'] ?? 'development') === 'development')>
                <span class="text-sm font-semibold">Development</span>
            </label>
            <label class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 cursor-pointer transition {{ ($environment['mode'] ?? 'development') === 'production' ? 'border-primary bg-primary/10' : 'border-black/10' }}">
                <input type="radio" name="mode" value="production" class="accent-primary" @checked(($environment['mode'] ?? 'development') === 'production')>
                <span class="text-sm font-semibold">Production</span>
            </label>
        </div>

        <div class="bg-primary/10 rounded-xl px-4 py-3 mb-6 text-xs text-black/60 leading-relaxed">
            <strong>How this applies:</strong> "Frontend URL" is used live — it's where password-reset and welcome emails link to, and it switches the moment you save. "Admin Panel URL" and "API URL" are reference values only (nothing in this Laravel app reads them back); copy the active API URL into the Next.js project's own <code class="font-mono">.env.development</code> / <code class="font-mono">.env.production</code> file, since Next.js bakes that value in at build time and can't read it from here at runtime.
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-display text-xs font-semibold uppercase tracking-wide text-black/40 mb-3">Development URLs</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Admin Panel URL</label>
                        <input type="url" name="dev_admin_url" value="{{ $environment['dev_admin_url'] ?? '' }}" placeholder="http://localhost/rinmora" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Frontend URL</label>
                        <input type="url" name="dev_frontend_url" value="{{ $environment['dev_frontend_url'] ?? '' }}" placeholder="http://localhost:3000" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">API URL</label>
                        <input type="url" name="dev_api_url" value="{{ $environment['dev_api_url'] ?? '' }}" placeholder="http://localhost/rinmora/api" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-display text-xs font-semibold uppercase tracking-wide text-black/40 mb-3">Production URLs</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Admin Panel URL</label>
                        <input type="url" name="prod_admin_url" value="{{ $environment['prod_admin_url'] ?? '' }}" placeholder="https://admin.rinmora.com" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Frontend URL</label>
                        <input type="url" name="prod_frontend_url" value="{{ $environment['prod_frontend_url'] ?? '' }}" placeholder="https://rinmora.com" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">API URL</label>
                        <input type="url" name="prod_api_url" value="{{ $environment['prod_api_url'] ?? '' }}" placeholder="https://api.rinmora.com" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 mt-6 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>
</div>
