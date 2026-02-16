<x-layout>
    <x-slot:title>Blog</x-slot:title>
    <div class="flex-1 w-full flex flex-col justify-start space-y-8">
        <section class="space-y-3">
            <p class="text-xs uppercase tracking-[0.2em] text-emerald-300/80">
                Blog
            </p>
            <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-slate-50">
                Coaching insights you can actually apply.
            </h1>
            <p class="text-sm sm:text-base text-slate-300">
                Practical tips on training, nutrition, and consistency to help you keep progressing week after week.
            </p>
        </section>

        @if ($blogs->isNotEmpty())
            <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($blogs as $blog)
                    <li class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:p-6">
                        <h2 class="text-lg font-semibold text-slate-50 mb-1">
                            <a href="{{ route('blog.show', $blog) }}" class="hover:underline">{{ $blog->title }}</a>
                        </h2>
                        @if ($blog->user?->name ?? $blog->author)
                            <p class="text-xs text-slate-400 mb-2">{{ $blog->user?->name ?? $blog->author }}</p>
                        @endif
                        <p class="text-sm text-slate-300">{{ $blog->description }}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-center max-w-md">
                <div
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-900 border border-slate-800 mb-4">
                    <span class="text-slate-400 text-lg">✏️</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-semibold text-slate-50 mb-2">
                    No blog posts yet
                </h1>
                <p class="text-sm text-slate-400">
                    Coach Lee is currently creating articles on training, nutrition, and staying consistent.
                    Check back soon for new posts.
                </p>
            </div>
        @endif
    </div>
</x-layout>
