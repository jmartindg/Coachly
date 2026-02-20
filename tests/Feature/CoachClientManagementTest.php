<?php

use App\Enums\ClientStatus;
use App\Models\Program;
use App\Models\ProgramAssignment;
use App\Models\User;
use App\Notifications\ApplicationApprovedNotification;
use App\Notifications\ApplicationSubmittedNotification;
use App\Notifications\CoachingFinishedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('coach can view clients page with applied and leads lists', function () {
    $coach = User::factory()->coach()->create();
    $lead = User::factory()->create(['name' => 'Lead User', 'email' => 'lead@example.com']);
    $applied = User::factory()->applied()->create(['name' => 'Applied User', 'email' => 'applied@example.com']);

    $response = actingAs($coach)->get(route('coach.clients'));

    $response->assertOk();
    $response->assertSee('Lead User');
    $response->assertSee('Applied User');
    $response->assertSee('Mark active');
});

test('coach can promote a lead to applied', function () {
    $coach = User::factory()->coach()->create();
    $lead = User::factory()->create(['name' => 'New Lead', 'email' => 'newlead@example.com']);

    $response = actingAs($coach)->post(route('coach.clients.promote', $lead));

    $response->assertRedirect(route('coach.clients'));
    $response->assertSessionHas('success');

    expect($lead->fresh()->client_status)->toBe(ClientStatus::Applied);
});

test('coach cannot promote a user who is already applied', function () {
    $coach = User::factory()->coach()->create();
    $applied = User::factory()->applied()->create();

    $response = actingAs($coach)->post(route('coach.clients.promote', $applied));

    $response->assertForbidden();
});

test('coach can view client detail page', function () {
    $coach = User::factory()->coach()->create();
    $client = User::factory()->applied()->create(['name' => 'Jane Doe', 'email' => 'jane@example.com']);

    $response = actingAs($coach)->get(route('coach.clients.show', $client));

    $response->assertOk();
    $response->assertSee('Jane Doe');
    $response->assertSee('jane@example.com');
});

test('coach marking client as finished sends a notification', function () {
    Notification::fake();

    $coach = User::factory()->coach()->create();
    $applied = User::factory()->applied()->create();

    $response = actingAs($coach)->post(route('coach.clients.finish', $applied));

    $response->assertRedirect(route('coach.clients'));
    $response->assertSessionHas('success');

    expect($applied->fresh()->client_status)->toBe(ClientStatus::Finished);
    Notification::assertSentTo($applied, CoachingFinishedNotification::class);
});

test('coach can approve a pending application', function () {
    Notification::fake();

    $coach = User::factory()->coach()->create();
    $pending = User::factory()->pending()->create(['name' => 'Pending User', 'email' => 'pending@example.com']);

    $response = actingAs($coach)->post(route('coach.clients.promote', $pending));

    $response->assertRedirect(route('coach.clients'));
    $response->assertSessionHas('success');

    expect($pending->fresh()->client_status)->toBe(ClientStatus::Applied);
    Notification::assertSentTo($pending, ApplicationApprovedNotification::class);
});

test('finished client can apply again', function () {
    /** @var User $client */
    $client = User::factory()->create([
        'name' => 'Finished Client',
        'email' => 'finished@example.com',
        'client_status' => ClientStatus::Finished,
    ]);

    $response = actingAs($client)->post(route('client.apply'), [
        'workout_style_preferences' => ['foundations', 'online_coaching', 'hybrid_coaching'],
    ]);

    $response->assertRedirect(route('client.index'));
    $response->assertSessionHas('success');

    expect($client->fresh()->client_status)->toBe(ClientStatus::Pending);
    expect($client->fresh()->workout_style_preferences)->toBe(['foundations', 'online_coaching', 'hybrid_coaching']);
});

test('lead client can apply with workout style preferences', function () {
    Notification::fake();

    $coach = User::factory()->coach()->create();

    /** @var User $client */
    $client = User::factory()->create([
        'client_status' => ClientStatus::Lead,
    ]);

    $response = actingAs($client)->post(route('client.apply'), [
        'workout_style_preferences' => ['online_coaching'],
    ]);

    $response->assertRedirect(route('client.index'));
    $response->assertSessionHas('success');

    expect($client->fresh()->client_status)->toBe(ClientStatus::Pending);
    expect($client->fresh()->workout_style_preferences)->toBe(['online_coaching']);
    Notification::assertSentTo($coach, ApplicationSubmittedNotification::class);
});

test('lead client can apply with requested session and coach sees it in notification', function () {
    Notification::fake();

    $coach = User::factory()->coach()->create();

    /** @var User $client */
    $client = User::factory()->create([
        'client_status' => ClientStatus::Lead,
        'name' => 'Session Booker',
    ]);

    $appointmentDate = now()->addDays(3)->format('Y-m-d');
    $appointmentTime = '09:00';

    $response = actingAs($client)->post(route('client.apply'), [
        'workout_style_preferences' => ['online_coaching'],
        'appointment_date' => $appointmentDate,
        'appointment_time' => $appointmentTime,
    ]);

    $response->assertRedirect(route('client.index'));
    $response->assertSessionHas('success');

    $client->refresh();
    expect($client->appointment_date->format('Y-m-d'))->toBe($appointmentDate);
    expect($client->appointment_time)->toBe($appointmentTime);
    expect($client->formattedRequestedSession())->not->toBeNull();

    Notification::assertSentTo($coach, ApplicationSubmittedNotification::class, function (ApplicationSubmittedNotification $n) use ($coach, $client): bool {
        $data = $n->toArray($coach);

        return str_contains($data['message'], 'Requested session:')
            && $data['appointment'] === $client->formattedRequestedSession();
    });
});

test('client cannot apply with more than three workout styles', function () {
    /** @var User $client */
    $client = User::factory()->create([
        'client_status' => ClientStatus::Lead,
    ]);

    $response = actingAs($client)->post(route('client.apply'), [
        'workout_style_preferences' => ['foundations', 'online_coaching', 'hybrid_coaching', 'invalid_style'],
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors('workout_style_preferences');

    expect($client->fresh()->client_status)->toBe(ClientStatus::Lead);
});

test('client cannot book a time slot already booked by another client', function () {
    $appointmentDate = now()->addDays(5)->format('Y-m-d');
    $appointmentTime = '10:00';

    User::factory()->create([
        'client_status' => ClientStatus::Pending,
        'appointment_date' => $appointmentDate,
        'appointment_time' => $appointmentTime,
    ]);

    /** @var User $client */
    $client = User::factory()->create([
        'client_status' => ClientStatus::Lead,
    ]);

    $response = actingAs($client)->post(route('client.apply'), [
        'workout_style_preferences' => ['online_coaching'],
        'appointment_date' => $appointmentDate,
        'appointment_time' => $appointmentTime,
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors('appointment_time');
    expect($client->fresh()->client_status)->toBe(ClientStatus::Lead);
});

test('approving a reapplying client does not auto-carry previous program', function () {
    $coach = User::factory()->coach()->create();
    $previousProgram = Program::factory()->create(['user_id' => $coach->id, 'name' => 'Previous Program']);
    $client = User::factory()->create([
        'client_status' => ClientStatus::Pending,
    ]);

    ProgramAssignment::query()->create([
        'user_id' => $client->id,
        'program_id' => $previousProgram->id,
        'assigned_at' => now()->subDays(30),
    ]);

    $response = actingAs($coach)->post(route('coach.clients.promote', $client));

    $response->assertRedirect(route('coach.clients'));
    $response->assertSessionHas('success');

    $freshClient = $client->fresh();
    expect($freshClient)->not->toBeNull();
    expect($freshClient->client_status)->toBe(ClientStatus::Applied);
    expect($freshClient->last_approved_at)->not->toBeNull();
    expect($freshClient->currentProgram())->toBeNull();
});
