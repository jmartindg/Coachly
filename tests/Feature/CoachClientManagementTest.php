<?php

use App\Enums\ClientStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('coach can view clients page with applied and leads lists', function () {
    $coach = User::factory()->coach()->create();
    $lead = User::factory()->create(['name' => 'Lead User', 'email' => 'lead@example.com']);
    $applied = User::factory()->applied()->create(['name' => 'Applied User', 'email' => 'applied@example.com']);

    $response = $this->actingAs($coach)->get(route('coach.clients'));

    $response->assertOk();
    $response->assertSee('Lead User');
    $response->assertSee('Applied User');
    $response->assertSee('Mark active');
});

test('coach can promote a lead to applied', function () {
    $coach = User::factory()->coach()->create();
    $lead = User::factory()->create(['name' => 'New Lead', 'email' => 'newlead@example.com']);

    $response = $this->actingAs($coach)->post(route('coach.clients.promote', $lead));

    $response->assertRedirect(route('coach.clients'));
    $response->assertSessionHas('success');

    expect($lead->fresh()->client_status)->toBe(ClientStatus::Applied);
});

test('coach cannot promote a user who is already applied', function () {
    $coach = User::factory()->coach()->create();
    $applied = User::factory()->applied()->create();

    $response = $this->actingAs($coach)->post(route('coach.clients.promote', $applied));

    $response->assertForbidden();
});

test('coach can view client detail page', function () {
    $coach = User::factory()->coach()->create();
    $client = User::factory()->applied()->create(['name' => 'Jane Doe', 'email' => 'jane@example.com']);

    $response = $this->actingAs($coach)->get(route('coach.clients.show', $client));

    $response->assertOk();
    $response->assertSee('Jane Doe');
    $response->assertSee('jane@example.com');
});

test('coach can approve a pending application', function () {
    $coach = User::factory()->coach()->create();
    $pending = User::factory()->pending()->create(['name' => 'Pending User', 'email' => 'pending@example.com']);

    $response = $this->actingAs($coach)->post(route('coach.clients.promote', $pending));

    $response->assertRedirect(route('coach.clients'));
    $response->assertSessionHas('success');

    expect($pending->fresh()->client_status)->toBe(ClientStatus::Applied);
});

test('finished client can apply again', function () {
    $client = User::factory()->create([
        'name' => 'Finished Client',
        'email' => 'finished@example.com',
        'client_status' => ClientStatus::Finished,
    ]);

    $response = $this->actingAs($client)->post(route('client.apply'));

    $response->assertRedirect(route('client.index'));
    $response->assertSessionHas('success');

    expect($client->fresh()->client_status)->toBe(ClientStatus::Pending);
});
