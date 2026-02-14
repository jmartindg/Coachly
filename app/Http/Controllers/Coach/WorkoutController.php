<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkoutRequest;
use App\Http\Requests\UpdateWorkoutRequest;
use App\Models\Program;
use App\Models\Workout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    public function store(StoreWorkoutRequest $request, Program $program): RedirectResponse
    {
        if ($program->user_id !== Auth::id()) {
            abort(403);
        }

        $sortOrder = $program->workouts()->max('sort_order') ?? 0;

        $program->workouts()->create([
            'name' => $request->validated('workout_name'),
            'sort_order' => $sortOrder + 1,
        ]);

        return redirect()->route('coach.programs.show', $program)
            ->with('success', 'Workout added.');
    }

    public function update(UpdateWorkoutRequest $request, Program $program, Workout $workout): RedirectResponse
    {
        if ($program->user_id !== Auth::id() || $workout->program_id !== $program->id) {
            abort(403);
        }

        $workout->update(['name' => $request->validated('name')]);

        return redirect()->route('coach.programs.show', $program)
            ->with('success', 'Workout updated.');
    }

    public function destroy(Program $program, Workout $workout): RedirectResponse
    {
        if ($program->user_id !== Auth::id() || $workout->program_id !== $program->id) {
            abort(403);
        }

        $workout->delete();

        return redirect()->route('coach.programs.show', $program)
            ->with('success', 'Workout removed.');
    }
}
