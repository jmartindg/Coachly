<?php

use App\Enums\Sex;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('coach can view profile page', function () {
    $coach = User::factory()->coach()->create();

    $response = actingAs($coach)->get(route('coach.profile'));

    $response->assertOk();
    $response->assertSee('Edit Profile');
    $response->assertSee($coach->email);
});

test('coach can update profile details', function () {
    $coach = User::factory()->coach()->create([
        'name' => 'Old Coach Name',
        'email' => 'oldcoach@example.com',
    ]);

    $response = actingAs($coach)->put(route('coach.profile.update'), [
        'name' => 'New Coach Name',
        'email' => 'newcoach@example.com',
        'mobile_number' => '+63 912 345 6789',
        'age' => 35,
        'sex' => Sex::Male->value,
        'height' => 175.5,
        'weight' => 74.2,
    ]);

    $response->assertRedirect(route('coach.index'));
    $response->assertSessionHas('success');

    $freshCoach = $coach->fresh();
    expect($freshCoach)->not->toBeNull()
        ->and($freshCoach->name)->toBe('New Coach Name')
        ->and($freshCoach->email)->toBe('newcoach@example.com')
        ->and($freshCoach->mobile_number)->toBe('+63 912 345 6789')
        ->and($freshCoach->age)->toBe(35)
        ->and($freshCoach->sex)->toBe(Sex::Male);
});
