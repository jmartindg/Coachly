<x-layout>
    <x-slot:title>{{ $blog->title }}</x-slot:title>
    <div class="flex-1 w-full flex flex-col justify-start space-y-8">
        <a href="{{ route('blog') }}" class="text-xs text-slate-400 hover:text-slate-50">← Back to blogs</a>
        <article class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:p-6 space-y-4">
            <h1 class="text-2xl font-semibold text-slate-50">{{ $blog->title }}</h1>
            @if ($blog->user?->name ?? $blog->author)
                <p class="text-sm text-slate-400">{{ $blog->user?->name ?? $blog->author }}</p>
            @endif
            <p class="text-xs text-slate-500">{{ $blog->created_at->format('M j, Y') }}</p>
            <div class="text-sm text-slate-300 whitespace-pre-line">{{ $blog->content }}</div>
        </article>
    </div>
</x-layout>
