<x-coach-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="space-y-10">
        @if (session('success'))
            <p class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-300">
                {{ session('success') }}
            </p>
        @endif

        <section>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-50">Dashboard</h1>
            <p class="text-sm text-slate-400">Welcome back, {{ auth()->user()->name }}.</p>
        </section>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('coach.clients') }}?tab=applied"
                class="rounded-xl border border-slate-800 bg-slate-900/60 p-4 hover:border-slate-700 transition-colors">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-2xl font-bold text-slate-50">{{ $stats['applied'] }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Active clients</p>
                    </div>
                    <x-iconpark-dumbbell-o class="h-5 w-5 text-emerald-300" />
                </div>
            </a>
            <a href="{{ route('coach.clients') }}?tab=pending"
                class="rounded-xl border border-slate-800 bg-slate-900/60 p-4 hover:border-slate-700 transition-colors">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-2xl font-bold text-slate-50">{{ $stats['pending'] }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Pending approval</p>
                    </div>
                    <x-gmdi-pending-actions-o class="h-5 w-5 text-amber-300" />
                </div>
            </a>
            <a href="{{ route('coach.clients') }}?tab=leads"
                class="rounded-xl border border-slate-800 bg-slate-900/60 p-4 hover:border-slate-700 transition-colors">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-2xl font-bold text-slate-50">{{ $stats['leads'] }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Leads</p>
                    </div>
                    <x-fluentui-form-20-o class="h-5 w-5 text-sky-300" />
                </div>
            </a>
            <a href="{{ route('coach.clients') }}?tab=finished"
                class="rounded-xl border border-slate-800 bg-slate-900/60 p-4 hover:border-slate-700 transition-colors">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-2xl font-bold text-slate-50">{{ $stats['finished'] }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Finished</p>
                    </div>
                    <x-gmdi-done class="h-5 w-5 text-emerald-300" />
                </div>
            </a>
        </section>

        <section class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-50">Blog</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Write and manage blog posts.</p>
                </div>
                <a href="{{ route('coach.blog.create') }}"
                    class="shrink-0 inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold text-slate-950 hover:bg-emerald-400 transition-colors">
                    New post
                </a>
            </div>
            @if ($blogs->isNotEmpty())
                <ul class="space-y-3">
                    @foreach ($blogs as $blog)
                        <li
                            class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h3 class="text-sm font-semibold text-slate-50 truncate">{{ $blog->title }}</h3>
                                @if ($blog->user?->name ?? $blog->author)
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $blog->user?->name ?? $blog->author }}</p>
                                @endif
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $blog->description }}</p>
                            </div>
                            <div class="shrink-0 flex gap-3 flex-col items-end">
                                <span class="text-xs text-slate-500">{{ $blog->created_at->format('M j, Y') }}</span>
                                <div class="flex gap-2 items-center">
                                    <a href="{{ route('coach.blog.edit', $blog) }}"
                                        class="text-xs text-slate-400 hover:text-slate-50 py-1">Edit</a>
                                    <form action="{{ route('coach.blog.destroy', $blog) }}" method="post"
                                        class="inline" onsubmit="return confirm('Delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs text-red-400 bg-red-500/10 px-2 py-1 rounded-full hover:text-red-300 cursor-pointer">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-6 text-center">
                    <p class="text-sm text-slate-400">No posts yet. Use “New post” when you're ready to add one.</p>
                </div>
            @endif
        </section>

        <section class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:p-6 space-y-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-50">Public Program Styles</h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    These cards power both the public programs page and client apply form.
                </p>
            </div>

            @if ($errors->isNotEmpty())
                <p class="rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-sm text-red-300">
                    Please fix the workout style fields below.
                </p>
            @endif

            <form action="{{ route('coach.workout-styles.update') }}" method="POST" class="space-y-4"
                data-workout-style-form>
                @csrf
                @method('PUT')
                @php($selectedPopularStyleId = old('popular_style_id', optional($workoutStyles->firstWhere('is_most_popular', true))->id))

                <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 space-y-2">
                    <p class="text-xs font-medium text-slate-300">Most popular badge</p>
                    <div class="flex flex-wrap gap-4 text-xs text-slate-300">
                        @foreach ($workoutStyles as $workoutStyle)
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="popular_style_id" value="{{ $workoutStyle->id }}"
                                    data-style-popular-radio
                                    class="size-4 border-slate-600 bg-slate-900 accent-emerald-500 focus:ring-2 focus:ring-emerald-500/60 focus:ring-offset-0"
                                    {{ (string) $selectedPopularStyleId === (string) $workoutStyle->id ? 'checked' : '' }}>
                                <span>{{ $workoutStyle->label }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-slate-500">Choose one style to show the "Most popular" tag on the public page.</p>
                </div>

                @foreach ($workoutStyles as $workoutStyle)
                    @php($styleId = (string) $workoutStyle->id)
                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 space-y-3">
                        <h3 class="text-sm font-semibold text-slate-100">{{ $workoutStyle->label }}</h3>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="space-y-1">
                                <label class="text-xs text-slate-400">Title</label>
                                <input type="text" name="styles[{{ $workoutStyle->id }}][label]"
                                    value="{{ old("styles.{$styleId}.label", $workoutStyle->label) }}"
                                    data-style-id="{{ $styleId }}" data-style-input="label"
                                    class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs text-slate-400">Subtitle</label>
                                <input type="text" name="styles[{{ $workoutStyle->id }}][subtitle]"
                                    value="{{ old("styles.{$styleId}.subtitle", $workoutStyle->subtitle) }}"
                                    data-style-id="{{ $styleId }}" data-style-input="subtitle"
                                    class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs text-slate-400">Description</label>
                            <textarea name="styles[{{ $workoutStyle->id }}][description]" rows="3"
                                data-style-id="{{ $styleId }}" data-style-input="description"
                                class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">{{ old("styles.{$styleId}.description", $workoutStyle->description) }}</textarea>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs text-slate-400">Bullets (one per line)</label>
                            <textarea name="styles[{{ $workoutStyle->id }}][bullets_text]" rows="4"
                                data-style-id="{{ $styleId }}" data-style-input="bullets"
                                class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">{{ old("styles.{$styleId}.bullets_text", implode("\n", $workoutStyle->bullets ?? [])) }}</textarea>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs text-slate-400">Hint</label>
                            <input type="text" name="styles[{{ $workoutStyle->id }}][hint]"
                                value="{{ old("styles.{$styleId}.hint", $workoutStyle->hint) }}"
                                data-style-id="{{ $styleId }}" data-style-input="hint"
                                class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        </div>
                    </div>
                @endforeach

                <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 space-y-4">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-100">Preview</h3>
                        <p class="text-xs text-slate-400">This is how cards will look on the public Programs page.</p>
                    </div>
                    <section class="grid gap-4 lg:grid-cols-3">
                        @foreach ($workoutStyles as $workoutStyle)
                            @php($styleId = (string) $workoutStyle->id)
                            @php($isMostPopular = (string) $selectedPopularStyleId === $styleId)
                            @php($previewBullets = collect(preg_split('/\r\n|\r|\n/', old("styles.{$styleId}.bullets_text", implode("\n", $workoutStyle->bullets ?? [])) ?? ''))->map(fn ($line) => trim($line))->filter()->values()->all())
                            <article
                                data-preview-style-id="{{ $styleId }}"
                                class="relative rounded-2xl p-5 sm:p-6 flex flex-col {{ $isMostPopular ? 'border-emerald-500/70 bg-slate-900/70 shadow-lg shadow-emerald-500/20' : 'border-slate-800 bg-slate-900/50' }} border">
                                <span data-preview-badge
                                    class="absolute -top-3 right-4 items-center rounded-full bg-emerald-500 px-3 py-1 text-[0.65rem] font-semibold text-slate-950 shadow-md shadow-emerald-500/40 {{ $isMostPopular ? 'inline-flex' : 'hidden' }}">
                                        Most popular
                                </span>
                                <h2 class="text-sm font-semibold text-slate-50 mb-1" data-preview-field="label">
                                    {{ old("styles.{$styleId}.label", $workoutStyle->label) }}
                                </h2>
                                <p class="text-xs text-slate-400 mb-4" data-preview-field="subtitle">
                                    {{ old("styles.{$styleId}.subtitle", $workoutStyle->subtitle) }}
                                </p>
                                <p data-preview-description
                                    class="text-xs mb-4 {{ $isMostPopular ? 'text-slate-200' : 'text-slate-300' }}"
                                    data-preview-field="description">
                                    {{ old("styles.{$styleId}.description", $workoutStyle->description) }}
                                </p>
                                <ul data-preview-bullets
                                    class="space-y-2 text-xs mb-4 {{ $isMostPopular ? 'text-slate-200' : 'text-slate-300' }}">
                                    @foreach ($previewBullets as $bullet)
                                        <li>• {{ $bullet }}</li>
                                    @endforeach
                                </ul>
                                <p data-preview-hint
                                    class="mt-auto text-[0.7rem] {{ $isMostPopular ? 'text-slate-200' : 'text-slate-400' }}"
                                    data-preview-field="hint">
                                    {{ old("styles.{$styleId}.hint", $workoutStyle->hint) }}
                                </p>
                            </article>
                        @endforeach
                    </section>
                </div>

                <button type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold text-slate-950 hover:bg-emerald-400 transition-colors cursor-pointer">
                    Save program styles
                </button>
            </form>
        </section>
    </div>
</x-coach-layout>
