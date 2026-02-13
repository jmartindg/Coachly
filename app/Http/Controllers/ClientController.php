<?php

namespace App\Http\Controllers;

use App\Enums\ClientStatus;
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
        return view('client.profile');
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
            'height' => $validated['height'] ?? null,
            'weight' => $validated['weight'] ?? null,
        ]);

        return redirect()->route('client.index')->with('success', 'Profile updated successfully.');
    }

    public function apply(): RedirectResponse
    {
        $user = auth()->user();

        if (! in_array($user->client_status, [ClientStatus::Lead, ClientStatus::Finished])) {
            return redirect()->route('client.index');
        }

        $isReapply = $user->client_status === ClientStatus::Finished;
        $user->update(['client_status' => ClientStatus::Pending]);

        $message = $isReapply
            ? 'You have applied again. Your coach will review and get in touch.'
            : 'Your application has been submitted. Your coach will review and get in touch.';

        return redirect()->route('client.index')->with('success', $message);
    }
}
