<div id="panel-timezone" class="tab-panel {{ request('tab') !== 'timezone' ? 'hidden' : '' }}">
    <form method="POST" action="{{ route('admin.system.settings.timezone') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PUT')
        <h2 class="font-bold text-sm mb-5">Date &amp; Time Format</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1.5">Timezone</label>
                <select name="timezone" id="tzSelect" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    @foreach (['Asia/Karachi' => '(GMT+05:00) Karachi/Islamabad', 'America/New_York' => '(GMT-05:00) New York', 'Europe/London' => '(GMT+00:00) London', 'Asia/Dubai' => '(GMT+04:00) Dubai', 'Europe/Paris' => '(GMT+01:00) Paris'] as $tz => $label)
                        <option value="{{ $tz }}" @selected(($timezone['timezone'] ?? 'Asia/Karachi') === $tz)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Date Format</label>
                    <select name="date_format" id="dateFormatSelect" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        @foreach (['d/m/Y' => 'DD/MM/YYYY', 'm/d/Y' => 'MM/DD/YYYY', 'Y-m-d' => 'YYYY-MM-DD'] as $fmt => $label)
                            <option value="{{ $fmt }}" @selected(($timezone['date_format'] ?? 'd/m/Y') === $fmt)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Time Format</label>
                    <select name="time_format" id="timeFormatSelect" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        <option value="12" @selected(($timezone['time_format'] ?? '12') === '12')>12-hour</option>
                        <option value="24" @selected(($timezone['time_format'] ?? '12') === '24')>24-hour</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-black/[0.03] rounded-xl p-4 mt-5 text-center">
            <p class="text-black/40 text-xs mb-1">Preview</p>
            <p id="tzPreview" class="text-sm font-semibold"></p>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>
</div>

<script>
  (function () {
    const dateSel = document.getElementById('dateFormatSelect');
    const timeSel = document.getElementById('timeFormatSelect');
    const preview = document.getElementById('tzPreview');
    if (!preview) return;

    function render() {
      const now = new Date();
      const dd = String(now.getDate()).padStart(2, '0');
      const mm = String(now.getMonth() + 1).padStart(2, '0');
      const yyyy = now.getFullYear();
      const map = { 'd/m/Y': `${dd}/${mm}/${yyyy}`, 'm/d/Y': `${mm}/${dd}/${yyyy}`, 'Y-m-d': `${yyyy}-${mm}-${dd}` };
      const datePart = map[dateSel.value] || map['d/m/Y'];

      let hours = now.getHours();
      const mins = String(now.getMinutes()).padStart(2, '0');
      let timePart;
      if (timeSel.value === '24') {
        timePart = `${String(hours).padStart(2, '0')}:${mins}`;
      } else {
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;
        timePart = `${hours}:${mins} ${ampm}`;
      }
      preview.textContent = `${datePart} · ${timePart}`;
    }

    dateSel.addEventListener('change', render);
    timeSel.addEventListener('change', render);
    render();
  })();
</script>
