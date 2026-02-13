<?php

namespace App\Http\Controllers;

use App\Enums\Sex;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    /**
     * Display the client dashboard.
     */
    public function __invoke(): View
    {
        return view('client.index');
    }

    public function profile(): View
    {
        return view('client.profile', [
            'editing' => request()->boolean('edit'),
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'age' => $validated['age'] ?? null,
            'sex' => array_key_exists('sex', $validated) && $validated['sex'] !== '' ? Sex::from($validated['sex']) : null,
        ]);

        return redirect()->route('client.profile')->with('success', 'Profile updated successfully.');
    }
}
