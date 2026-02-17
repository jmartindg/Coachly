<?php

use App\Models\Program;
use App\Models\ProgramAssignment;
use App\Models\User;
use App\Models\Workout;
use App\Notifications\ProgramAssignedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

test('coach can view programs index', function () {
    $coach = User::factory()->coach()->create();
    $program = Program::factory()->create(['user_id' => $coach->id, 'name' => 'Strength Builder']);

    $response = $this->actingAs($coach)->get(route('coach.programs'));

    $response->assertOk();
    $response->assertSee('Strength Builder');
});

test('coach can create a program', function () {
    $coach = User::factory()->coach()->create();

    $response = $this->actingAs($coach)->post(route('coach.programs.store'), [
        'name' => '12-Week Hypertrophy',
        'description' => 'Build muscle over 12 weeks',
        'duration_weeks' => 12,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $program = Program::query()->where('user_id', $coach->id)->first();
    expect($program)->not->toBeNull()
        ->and($program->name)->toBe('12-Week Hypertrophy')
        ->and($program->duration_weeks)->toBe(12);
});

test('coach can add workout to program', function () {
    $coach = User::factory()->coach()->create();
    $program = Program::factory()->create(['user_id' => $coach->id]);

    $response = $this->actingAs($coach)->post(route('coach.programs.workouts.store', $program), [
        'workout_name' => 'Upper Body Day',
    ]);

    $response->assertRedirect(route('coach.programs.show', $program));
    $response->assertSessionHas('success');

    $workout = $program->workouts()->first();
    expect($workout)->not->toBeNull()
        ->and($workout->name)->toBe('Upper Body Day');
});

test('coach can update workout title', function () {
    $coach = User::factory()->coach()->create();
    $program = Program::factory()->create(['user_id' => $coach->id]);
    $workout = Workout::factory()->create(['program_id' => $program->id, 'name' => 'Leg Day']);

    $response = $this->actingAs($coach)->put(route('coach.programs.workouts.update', [$program, $workout]), [
        'name' => 'Lower Body',
    ]);

    $response->assertRedirect(route('coach.programs.show', $program));
    $response->assertSessionHas('success');

    expect($workout->fresh()->name)->toBe('Lower Body');
});

test('coach can add exercise to workout', function () {
    $coach = User::factory()->coach()->create();
    $program = Program::factory()->create(['user_id' => $coach->id]);
    $workout = Workout::factory()->create(['program_id' => $program->id]);

    $response = $this->actingAs($coach)->post(route('coach.workouts.exercises.store', $workout), [
        'name' => 'Bench Press',
        'sets' => 4,
        'reps' => '8-10',
    ]);

    $response->assertRedirect(route('coach.programs.show', $program));
    $response->assertSessionHas('success');

    $exercise = $workout->exercises()->first();
    expect($exercise)->not->toBeNull()
        ->and($exercise->name)->toBe('Bench Press')
        ->and($exercise->sets)->toBe(4);
});

test('coach can assign program to active client', function () {
    Notification::fake();

    $coach = User::factory()->coach()->create();
    $program = Program::factory()->create(['user_id' => $coach->id]);
    $client = User::factory()->applied()->create();

    $response = $this->actingAs($coach)->post(route('coach.clients.assign-program', $client), [
        'program_id' => $program->id,
    ]);

    $response->assertRedirect(route('coach.clients.show', $client));
    $response->assertSessionHas('success');

    expect($client->currentProgram()->id)->toBe($program->id);
    Notification::assertSentTo($client, ProgramAssignedNotification::class);
});

test('coach cannot assign program to non-applied client', function () {
    $coach = User::factory()->coach()->create();
    $program = Program::factory()->create(['user_id' => $coach->id]);
    $lead = User::factory()->create();

    $response = $this->actingAs($coach)->post(route('coach.clients.assign-program', $lead), [
        'program_id' => $program->id,
    ]);

    $response->assertForbidden();
});

test('reassigning to different program updates client view', function () {
    $coach = User::factory()->coach()->create();
    $programA = Program::factory()->create(['user_id' => $coach->id, 'name' => 'Program A']);
    $programB = Program::factory()->create(['user_id' => $coach->id, 'name' => 'Program B']);
    $client = User::factory()->applied()->create();
    ProgramAssignment::create(['program_id' => $programA->id, 'user_id' => $client->id]);

    $this->actingAs($coach)->post(route('coach.clients.assign-program', $client), [
        'program_id' => $programB->id,
    ]);

    expect($client->fresh()->currentProgram()?->id)->toBe($programB->id);
});

test('program history shows all assignments including repeated programs', function () {
    $coach = User::factory()->coach()->create();
    $programA = Program::factory()->create(['user_id' => $coach->id, 'name' => 'Program A']);
    $programB = Program::factory()->create(['user_id' => $coach->id, 'name' => 'Program B']);
    $client = User::factory()->applied()->create();

    $this->actingAs($coach)->post(route('coach.clients.assign-program', $client), ['program_id' => $programA->id]);
    $this->actingAs($coach)->post(route('coach.clients.assign-program', $client), ['program_id' => $programB->id]);
    $this->actingAs($coach)->post(route('coach.clients.assign-program', $client), ['program_id' => $programA->id]);

    $history = $client->programAssignments()->with('program')->orderByDesc('assigned_at')->get();
    expect($history)->toHaveCount(3)
        ->and($history->pluck('program.name')->toArray())->toBe(['Program A', 'Program B', 'Program A']);
});

test('reassigning same program does not fail with unique constraint', function () {
    $coach = User::factory()->coach()->create();
    $program = Program::factory()->create(['user_id' => $coach->id]);
    $client = User::factory()->applied()->create();
    ProgramAssignment::create(['program_id' => $program->id, 'user_id' => $client->id]);

    $response = $this->actingAs($coach)->post(route('coach.clients.assign-program', $client), [
        'program_id' => $program->id,
    ]);

    $response->assertRedirect(route('coach.clients.show', $client));
    $response->assertSessionHas('success');
    expect(ProgramAssignment::where('user_id', $client->id)->count())->toBe(1);
});
