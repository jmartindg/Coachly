<form action="{{ route('client.apply') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Preferred workout styles</p>
        <p class="text-xs text-slate-500 mb-4">Choose up to 3 styles so your coach can tailor your training.</p>

        <div class="grid gap-3 sm:grid-cols-3">
            @foreach ($workoutStyleOptions as $key => $style)
                @php($isSelected = in_array($key, $selectedWorkoutStyles, true))
                <label
                    class="rounded-xl border px-4 py-3 transition-colors cursor-pointer {{ $isSelected ? 'border-emerald-500/70 bg-emerald-500/10' : 'border-slate-700 bg-slate-950/60 hover:border-slate-600' }}">
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

    <button type="submit"
        class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors cursor-pointer">
        {{ $buttonLabel }}
    </button>
</form>
