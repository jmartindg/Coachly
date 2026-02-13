<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use App\Enums\Sex;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Register extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'age' => ['nullable', 'integer', 'min:1', 'max:150'],
            'sex' => ['nullable', Rule::enum(Sex::class)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create user (default role: client)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => Role::Client,
            'age' => $validated['age'] ?? null,
            'sex' => array_key_exists('sex', $validated) && $validated['sex'] !== '' ? Sex::from($validated['sex']) : null,
        ]);

        // Login user
        Auth::login($user);

        return redirect()->route('client.index')->with('success', 'Welcome to Coachly Fitness!');
    }
}
