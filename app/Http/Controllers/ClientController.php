<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ClientController extends Controller
{
    /**
     * Display the client dashboard.
     */
    public function __invoke(): View
    {
        return view('client.index');
    }
}
