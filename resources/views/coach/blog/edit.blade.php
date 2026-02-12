<x-coach-layout>
    <x-slot:title>Edit post</x-slot:title>

    <div class="space-y-8">
        <div class="flex flex-col gap-2">
            <a href="{{ route('coach.index') }}" class="text-xs text-slate-400 hover:text-slate-50 transition-colors">←
                Dashboard</a>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-50">Edit post</h1>
        </div>

        <form class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:p-6 space-y-5" method="post"
            action="{{ route('coach.blog.update', $blog) }}">
            @csrf
            @method('PUT')
            @if ($errors->isNotEmpty())
                <p class="rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-sm text-red-300">
                    Please fix the errors below.
                </p>
            @endif

            <div class="space-y-2">
                <label for="title" class="block text-sm font-medium text-slate-200">Title</label>
                <input type="text" name="title" id="title" placeholder="Blog post title"
                    value="{{ old('title', $blog->title) }}"
                    class="w-full rounded-lg border {{ $errors->has('title') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                @error('title')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="slug" class="block text-sm font-medium text-slate-200">Slug</label>
                <input type="text" name="slug" id="slug" placeholder="blog-post-title" readonly
                    value="{{ old('slug', $blog->slug) }}"
                    class="w-full rounded-lg border {{ $errors->has('slug') ? 'border-red-500' : 'border-slate-700' }} bg-slate-900/80 px-3 py-2 text-sm text-slate-400 cursor-not-allowed">
                @error('slug')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-slate-200">Description</label>
                <textarea name="description" id="description" rows="4" placeholder="Short description or excerpt"
                    class="w-full rounded-lg border {{ $errors->has('description') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 resize-y">{{ old('description', $blog->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="content" class="block text-sm font-medium text-slate-200">Content</label>
                <textarea name="content" id="content" rows="10" placeholder="Post content"
                    class="w-full rounded-lg border {{ $errors->has('content') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 resize-y">{{ old('content', $blog->content) }}</textarea>
                @error('content')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="user_id" class="block text-sm font-medium text-slate-200">Author</label>
                <div class="relative">
                    <select name="user_id" id="user_id"
                        class="w-full appearance-none rounded-lg border {{ $errors->has('user_id') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 pl-3 pr-10 py-2 text-sm text-slate-50 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        <option value="">Select author</option>
                        @foreach ($coaches as $coach)
                            <option value="{{ $coach->id }}"
                                {{ old('user_id', $blog->user_id) == $coach->id ? 'selected' : '' }}>
                                {{ $coach->name }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="pointer-events-none absolute right-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                    </svg>
                </div>
                @error('user_id')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors cursor-pointer">
                    Update
                </button>
                <a href="{{ route('coach.index') }}"
                    class="inline-flex items-center justify-center rounded-full border border-slate-600 px-4 py-2 text-sm font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('title').addEventListener('input', function() {
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
