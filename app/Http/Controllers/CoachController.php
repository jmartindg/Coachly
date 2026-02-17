<?php

namespace App\Http\Controllers;

use App\Enums\ClientStatus;
use App\Enums\Role;
use App\Enums\Sex;
use App\Http\Requests\AssignProgramRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateWorkoutStylesRequest;
use App\Models\Blog;
use App\Models\Program;
use App\Models\User;
use App\Models\WorkoutStyle;
use App\Notifications\ApplicationApprovedNotification;
use App\Notifications\CoachingFinishedNotification;
use App\Notifications\ProgramAssignedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CoachController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::query()->with('user')->latest()->get();
        $workoutStyles = WorkoutStyle::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $stats = [
            'applied' => User::query()->where('role', Role::Client)->where('client_status', ClientStatus::Applied)->count(),
            'pending' => User::query()->where('role', Role::Client)->where('client_status', ClientStatus::Pending)->count(),
            'leads' => User::query()->where('role', Role::Client)->where('client_status', ClientStatus::Lead)->count(),
            'finished' => User::query()->where('role', Role::Client)->where('client_status', ClientStatus::Finished)->count(),
        ];

        return view('coach.index', [
            'blogs' => $blogs,
            'stats' => $stats,
            'workoutStyles' => $workoutStyles,
        ]);
    }

    public function updateWorkoutStyles(UpdateWorkoutStylesRequest $request): RedirectResponse
    {
        $stylesPayload = $request->validated('styles');
        $popularStyleId = $request->validated('popular_style_id');
        $styles = WorkoutStyle::query()
            ->whereIn('id', array_map('intval', array_keys($stylesPayload)))
            ->get()
            ->keyBy('id');

        DB::transaction(function () use ($stylesPayload, $styles, $popularStyleId): void {
            foreach ($stylesPayload as $styleId => $styleData) {
                $style = $styles->get((int) $styleId);

                if (! $style) {
                    continue;
                }

                $style->update([
                    'label' => $styleData['label'],
                    'subtitle' => $styleData['subtitle'],
                    'description' => $styleData['description'],
                    'hint' => $styleData['hint'],
                    'bullets' => collect(preg_split('/\r\n|\r|\n/', $styleData['bullets_text'] ?? ''))
                        ->map(static fn (string $line): string => trim($line))
                        ->filter()
                        ->values()
                        ->all(),
                ]);
            }

            WorkoutStyle::query()->update(['is_most_popular' => false]);

            if ($popularStyleId) {
                WorkoutStyle::query()
                    ->whereKey((int) $popularStyleId)
                    ->update(['is_most_popular' => true]);
            }
        });

        return redirect()
            ->route('coach.index')
            ->with('success', 'Program styles updated successfully.');
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

        /** @var User $coach */
        $coach = Auth::user();
        $user->notify(new ProgramAssignedNotification($coach, $program));

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

        /** @var User $coach */
        $coach = Auth::user();

        $user->update([
            'client_status' => ClientStatus::Applied,
            'last_approved_at' => now(),
        ]);

        $user->notify(new ApplicationApprovedNotification($coach));

        return redirect()->route('coach.clients')->with('success', "{$user->name} is now an active client.");
    }

    public function finishClient(User $user): RedirectResponse
    {
        if ($user->role !== Role::Client || $user->client_status !== ClientStatus::Applied) {
            abort(403);
        }

        /** @var User $coach */
        $coach = Auth::user();

        $user->update(['client_status' => ClientStatus::Finished]);
        $user->notify(new CoachingFinishedNotification($coach));

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

    public function profile(): View
    {
        return view('coach.profile');
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
            'mobile_number' => $validated['mobile_number'] ?? null,
        ]);

        return redirect()->route('coach.index')->with('success', 'Profile updated successfully.');
    }
}
