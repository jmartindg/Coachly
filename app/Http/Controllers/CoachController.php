<?php

namespace App\Http\Controllers;

use App\Enums\ClientStatus;
use App\Enums\Role;
use App\Http\Requests\AssignProgramRequest;
use App\Models\Blog;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CoachController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::query()->with('user')->latest()->get();

        $stats = [
            'applied' => User::query()->where('role', Role::Client)->where('client_status', ClientStatus::Applied)->count(),
            'pending' => User::query()->where('role', Role::Client)->where('client_status', ClientStatus::Pending)->count(),
            'leads' => User::query()->where('role', Role::Client)->where('client_status', ClientStatus::Lead)->count(),
            'finished' => User::query()->where('role', Role::Client)->where('client_status', ClientStatus::Finished)->count(),
        ];

        return view('coach.index', ['blogs' => $blogs, 'stats' => $stats]);
    }

    public function clients(): View
    {
        $applied = User::query()
            ->where('role', Role::Client)
            ->where('client_status', ClientStatus::Applied)
            ->orderBy('name')
            ->get();

        $pending = User::query()
            ->where('role', Role::Client)
            ->where('client_status', ClientStatus::Pending)
            ->orderBy('created_at', 'desc')
            ->get();

        $leads = User::query()
            ->where('role', Role::Client)
            ->where('client_status', ClientStatus::Lead)
            ->orderBy('created_at', 'desc')
            ->get();

        $finished = User::query()
            ->where('role', Role::Client)
            ->where('client_status', ClientStatus::Finished)
            ->orderBy('name')
            ->get();

        $activeTab = request()->query('tab', 'applied');
        if (! in_array($activeTab, ['applied', 'pending', 'leads', 'finished'])) {
            $activeTab = 'applied';
        }

        return view('coach.clients.index', [
            'applied' => $applied,
            'pending' => $pending,
            'leads' => $leads,
            'finished' => $finished,
            'activeTab' => $activeTab,
        ]);
    }

    public function showClient(User $user): View|RedirectResponse
    {
        if ($user->role !== Role::Client) {
            abort(404);
        }

        $programs = Program::query()
            ->where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        $currentProgram = $user->currentProgram();

        $programHistory = $user->programAssignments()
            ->with('program')
            ->orderByDesc('assigned_at')
            ->orderByDesc('id')
            ->get();

        return view('coach.clients.show', [
            'client' => $user,
            'programs' => $programs,
            'currentProgram' => $currentProgram,
            'programHistory' => $programHistory,
        ]);
    }

    public function assignProgram(AssignProgramRequest $request, User $user): RedirectResponse
    {
        if ($user->role !== Role::Client || $user->client_status !== ClientStatus::Applied) {
            abort(403);
        }

        $program = Program::findOrFail($request->validated('program_id'));
        if ($program->user_id !== Auth::id()) {
            abort(403);
        }

        $currentProgram = $user->currentProgram();
        if ($currentProgram?->id === $program->id) {
            return redirect()->route('coach.clients.show', $user)
                ->with('success', "{$user->name} already has {$program->name}.");
        }

        $user->programAssignments()->create([
            'program_id' => $program->id,
            'assigned_at' => now(),
        ]);

        return redirect()
            ->route('coach.clients.show', $user)
            ->with('success', "{$program->name} assigned to {$user->name}.")
            ->setStatusCode(303);
    }

    public function promoteClient(User $user): RedirectResponse
    {
        if ($user->role !== Role::Client || ! in_array($user->client_status, [ClientStatus::Lead, ClientStatus::Pending])) {
            abort(403);
        }

        $user->update(['client_status' => ClientStatus::Applied]);

        return redirect()->route('coach.clients')->with('success', "{$user->name} is now an active client.");
    }

    public function finishClient(User $user): RedirectResponse
    {
        if ($user->role !== Role::Client || $user->client_status !== ClientStatus::Applied) {
            abort(403);
        }

        $user->update(['client_status' => ClientStatus::Finished]);

        return redirect()->route('coach.clients')->with('success', "{$user->name} has been marked as finished.");
    }

    public function revertToLead(User $user): RedirectResponse
    {
        if ($user->role !== Role::Client || ! in_array($user->client_status, [ClientStatus::Applied, ClientStatus::Pending])) {
            abort(403);
        }

        $user->update(['client_status' => ClientStatus::Lead]);

        return redirect()->route('coach.clients')->with('success', "{$user->name} has been moved back to leads.");
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
