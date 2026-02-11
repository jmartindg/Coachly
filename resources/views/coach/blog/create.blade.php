<x-coach-layout>
    <x-slot:title>New post</x-slot:title>

    <div class="space-y-8">
        <section>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-50">New post</h1>
            <p class="text-sm text-slate-400">Create a new blog post.</p>
        </section>

        <form class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:p-6 space-y-5" method="post"
            action="{{ route('coach.blog.store') }}">
            @csrf
            @if ($errors->isNotEmpty())
                <p class="rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-sm text-red-300">
                    Please fix the errors below.
                </p>
            @endif

            <div class="space-y-2">
                <label for="title" class="block text-sm font-medium text-slate-200">Title</label>
                <input type="text" name="title" id="title" placeholder="Blog post title" value="{{ old('title') }}"
                    class="w-full rounded-lg border {{ $errors->has('title') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                @error('title')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="slug" class="block text-sm font-medium text-slate-200">Slug</label>
                <input type="text" name="slug" id="slug" placeholder="blog-post-title" readonly
                    value="{{ old('slug') }}"
                    class="w-full rounded-lg border {{ $errors->has('slug') ? 'border-red-500' : 'border-slate-700' }} bg-slate-900/80 px-3 py-2 text-sm text-slate-400 cursor-not-allowed">
                @error('slug')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-slate-200">Description</label>
                <textarea name="description" id="description" rows="4" placeholder="Short description or excerpt"
                    class="w-full rounded-lg border {{ $errors->has('description') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 resize-y">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="content" class="block text-sm font-medium text-slate-200">Content</label>
                <textarea name="content" id="content" rows="10" placeholder="Post content"
                    class="w-full rounded-lg border {{ $errors->has('content') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 resize-y">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="author" class="block text-sm font-medium text-slate-200">Author</label>
                <input type="text" name="author" id="author" placeholder="Author name" value="{{ old('author') }}"
                    class="w-full rounded-lg border {{ $errors->has('author') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                @error('author')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors">
                    Publish
                </button>
                <a href="{{ route('coach.index') }}"
                    class="inline-flex items-center justify-center rounded-full border border-slate-600 px-4 py-2 text-sm font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('title').addEventListener('input', function () {
            const slug = this.value
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^a-z0-9-]/g, '')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            document.getElementById('slug').value = slug;
        });
    </script>
</x-coach-layout>
