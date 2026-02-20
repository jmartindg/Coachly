<form action="{{ route('client.apply') }}" method="POST" class="space-y-4"
    data-booked-slots-url="{{ route('client.booked-slots') }}">
    @csrf
    <div>
        <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Preferred workout styles</p>
        <p class="text-xs text-slate-500 mb-4">Choose up to 3 styles so your coach can tailor your training.</p>

        <div class="grid gap-3 sm:grid-cols-3">
            @foreach ($workoutStyleOptions as $key => $style)
                @php
                    $isSelected = in_array($key, $selectedWorkoutStyles, true);
                    $labelClass = $isSelected
                        ? 'border-emerald-500/70 bg-emerald-500/10'
                        : 'border-slate-700 bg-slate-950/60 hover:border-slate-600';
                @endphp
                <label class="rounded-xl border px-4 py-3 transition-colors cursor-pointer {{ $labelClass }}">
                    <div class="flex items-start gap-2.5">
                        <input type="checkbox" name="workout_style_preferences[]" value="{{ $key }}"
                            class="mt-0.5 size-4 rounded border-slate-600 bg-slate-900 accent-emerald-500 focus:ring-2 focus:ring-emerald-500/60 focus:ring-offset-0"
                            {{ $isSelected ? 'checked' : '' }}>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-slate-100">{{ $style['label'] }}</p>
                            <p class="text-xs text-slate-500">{{ $style['subtitle'] }}</p>
                            <p class="text-xs text-slate-400">{{ $style['description'] }}</p>
                            <p class="text-[0.7rem] text-slate-500">{{ $style['hint'] }}</p>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    @error('workout_style_preferences')
        <p class="text-xs text-rose-300">{{ $message }}</p>
    @enderror
    @error('workout_style_preferences.*')
        <p class="text-xs text-rose-300">{{ $message }}</p>
    @enderror

    <div class="border-t border-slate-800 pt-6 space-y-4">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Book appointment for coach</p>
        <p class="text-xs text-slate-500">Choose a date and time for your coaching call.</p>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="appointment_date" class="block text-xs font-medium text-slate-400 mb-1.5">Date</label>
                <input type="date" id="appointment_date" name="appointment_date"
                    value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}"
                    class="w-full rounded-lg border border-slate-600 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 placeholder-slate-500 focus:border-emerald-500/60 focus:ring-2 focus:ring-emerald-500/30 focus:ring-offset-0 focus:ring-offset-slate-900 scheme-dark">
            </div>
            <div>
                <label for="appointment_time" class="block text-xs font-medium text-slate-400 mb-1.5">Start time</label>
                <div class="relative">
                    <select id="appointment_time" name="appointment_time"
                        class="w-full appearance-none rounded-lg border border-slate-600 bg-slate-900/60 pl-3 pr-10 py-2 text-sm text-slate-100 focus:border-emerald-500/60 focus:ring-2 focus:ring-emerald-500/30 focus:ring-offset-0 focus:ring-offset-slate-900">
                        <option value="">Select time</option>
                        @foreach ([8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18] as $hour)
                            @php
                                $display =
                                    $hour <= 12
                                        ? ($hour === 12
                                            ? '12:00 PM'
                                            : $hour . ':00 AM')
                                        : $hour - 12 . ':00 PM';
                            @endphp
                            <option value="{{ sprintf('%02d:00', $hour) }}"
                                {{ old('appointment_time') === sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                {{ $display }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="pointer-events-none absolute right-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <button type="submit"
        class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors cursor-pointer">
        {{ $buttonLabel }}
    </button>
</form>

<script>
    document.querySelector('#appointment_date')?.addEventListener('change', function () {
        const dateInput = this;
        const date = dateInput.value;
        const timeSelect = document.querySelector('#appointment_time');
        const form = dateInput.closest('form');
        const url = form?.dataset.bookedSlotsUrl;

        const options = timeSelect?.querySelectorAll('option[value]');
        options?.forEach(opt => {
            opt.disabled = false;
            opt.removeAttribute('aria-disabled');
        });
        if (!date || !url || !timeSelect) {
            return;
        }
        fetch(`${url}?date=${encodeURIComponent(date)}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(res => res.json())
            .then(data => {
                const booked = new Set(data.booked_times ?? []);
                options?.forEach(opt => {
                    if (booked.has(opt.value)) {
                        opt.disabled = true;
                        opt.setAttribute('aria-disabled', 'true');
                    }
                });
                if (timeSelect.value && booked.has(timeSelect.value)) {
                    timeSelect.value = '';
                }
            })
            .catch(() => {});
    });
    const dateInput = document.querySelector('#appointment_date');
    if (dateInput?.value) {
        dateInput.dispatchEvent(new Event('change'));
    }
</script>
