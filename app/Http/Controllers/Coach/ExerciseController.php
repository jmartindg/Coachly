<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExerciseRequest;
use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    public function store(StoreExerciseRequest $request, Workout $workout): RedirectResponse
    {
        $program = $workout->program;
        if ($program->user_id !== Auth::id()) {
            abort(403);
        }

        $sortOrder = $workout->exercises()->max('sort_order') ?? 0;

        $workout->exercises()->create([
            'name' => $request->validated('name'),
            'sets' => $request->validated('sets'),
            'reps' => $request->validated('reps'),
            'rest_seconds' => $request->validated('rest_seconds'),
            'notes' => $request->validated('notes'),
            'sort_order' => $sortOrder + 1,
        ]);

        return redirect()->route('coach.programs.show', $program)
            ->with('success', 'Exercise added.');
    }

    public function destroy(Workout $workout, Exercise $exercise): RedirectResponse
    {
        $program = $workout->program;
        if ($program->user_id !== Auth::id()
            || $exercise->workout_id !== $workout->id) {
            abort(403);
        }

        $exercise->delete();

        return redirect()->route('coach.programs.show', $program)
            ->with('success', 'Exercise removed.');
    }
}
