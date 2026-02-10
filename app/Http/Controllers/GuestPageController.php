<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestPageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function programs()
    {
        return view('programs');
    }

    public function blog()
    {
        return view('blog');
    }

    public function login()
    {
        return view('login');
    }
}
