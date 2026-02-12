<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Blog;
use App\Models\User;
use Illuminate\View\View;

class CoachController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::query()->with('user')->latest()->get();

        return view('coach.index', ['blogs' => $blogs]);
    }

    public function clients(): View
    {
        return view('coach.clients.index');
    }

    public function createBlog(): View
    {
        $coaches = User::query()->where('role', Role::Coach)->orderBy('name')->get();

        return view('coach.blog.create', ['coaches' => $coaches]);
    }

    public function editBlog(Blog $blog): View
    {
        $coaches = User::query()->where('role', Role::Coach)->orderBy('name')->get();

        return view('coach.blog.edit', ['blog' => $blog, 'coaches' => $coaches]);
    }
}
