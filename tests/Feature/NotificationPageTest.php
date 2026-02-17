<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('guest is redirected from notifications page', function () {
    $response = get(route('notifications.index'));

    $response->assertRedirect(route('login'));
});

test('client can view notifications page', function () {
    /** @var User $client */
    $client = User::factory()->create();

    $response = actingAs($client)->get(route('notifications.index'));

    $response->assertOk();
    $response->assertSee('All notifications');
});

test('coach can view notifications page', function () {
    $coach = User::factory()->coach()->create();

    $response = actingAs($coach)->get(route('notifications.index'));

    $response->assertOk();
    $response->assertSee('All notifications');
});
