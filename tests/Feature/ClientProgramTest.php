<?php

use App\Models\Program;
use App\Models\ProgramAssignment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('client can view their assigned program', function () {
    $client = User::factory()->applied()->create();
    $program = Program::factory()->create(['name' => 'My Training Plan']);
    ProgramAssignment::create(['program_id' => $program->id, 'user_id' => $client->id]);

    $response = $this->actingAs($client)->get(route('client.program'));

    $response->assertOk();
    $response->assertSee('My Training Plan');
});

test('client without program is redirected to dashboard', function () {
    $client = User::factory()->applied()->create();

    $response = $this->actingAs($client)->get(route('client.program'));

    $response->assertRedirect(route('client.index'));
    $response->assertSessionHas('info');
});
