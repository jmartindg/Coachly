<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        $programs = Program::query()
            ->where('user_id', Auth::id())
            ->withCount('workouts')
            ->latest()
            ->get();

        return view('coach.programs.index', ['programs' => $programs]);
    }

    public function create(): View
    {
        return view('coach.programs.create');
    }

    public function store(StoreProgramRequest $request): RedirectResponse
    {
        $program = Program::create([
            'user_id' => Auth::id(),
            'name' => $request->validated('name'),
            'description' => $request->validated('description'),
            'duration_weeks' => $request->validated('duration_weeks'),
        ]);

        return redirect()->route('coach.programs.show', $program)
            ->with('success', 'Program created. Add workouts and exercises.');
    }

    public function show(Program $program): View|RedirectResponse
    {
        if ($program->user_id !== Auth::id()) {
            abort(403);
        }

        $program->load(['workouts.exercises']);

        return view('coach.programs.show', ['program' => $program]);
    }

    public function edit(Program $program): View|RedirectResponse
    {
        if ($program->user_id !== Auth::id()) {
            abort(403);
        }

        return view('coach.programs.edit', ['program' => $program]);
    }

    public function update(UpdateProgramRequest $request, Program $program): RedirectResponse
    {
        if ($program->user_id !== Auth::id()) {
            abort(403);
        }

        $program->update($request->validated());

        return redirect()->route('coach.programs.show', $program)
            ->with('success', 'Program updated.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        if ($program->user_id !== Auth::id()) {
            abort(403);
        }

        $program->delete();

        return redirect()->route('coach.programs')
            ->with('success', 'Program deleted.');
    }
}
