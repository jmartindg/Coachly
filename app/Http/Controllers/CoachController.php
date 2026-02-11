<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\View\View;

class CoachController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::query()->latest()->get();

        return view('coach.index', ['blogs' => $blogs]);
    }

    public function clients(): View
    {
        return view('coach.clients.index');
    }

    public function createBlog(): View
    {
        return view('coach.blog.create');
    }

    public function editBlog(Blog $blog): View
    {
        return view('coach.blog.edit', ['blog' => $blog]);
    }
}
