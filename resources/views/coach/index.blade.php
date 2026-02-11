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
            <p class="text-sm text-slate-400">Welcome back, Coach Lee.</p>
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
                                @if ($blog->author)
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $blog->author }}</p>
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
    </div>
</x-coach-layout>
