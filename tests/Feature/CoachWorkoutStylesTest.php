<?php

use App\Models\User;
use App\Models\WorkoutStyle;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('coach can view workout styles section on dashboard', function () {
    $coach = User::factory()->coach()->create();

    $response = actingAs($coach)->get(route('coach.index'));

    $response->assertOk();
    $response->assertSee('Public Program Styles');
    $response->assertSee('Foundations');
});

test('coach can update workout style content from dashboard', function () {
    $coach = User::factory()->coach()->create();
    $styles = WorkoutStyle::query()->orderBy('sort_order')->get();
    $onlineStyle = $styles->firstWhere('key', 'online_coaching');

    expect($onlineStyle)->not->toBeNull();

    $payload = [
        'styles' => $styles
            ->mapWithKeys(function (WorkoutStyle $style): array {
                return [
                    $style->id => [
                        'label' => $style->label,
                        'subtitle' => $style->subtitle,
                        'description' => $style->description,
                        'hint' => $style->hint,
                        'bullets_text' => implode("\n", $style->bullets ?? []),
                    ],
                ];
            })
            ->toArray(),
    ];

    $payload['styles'][$onlineStyle->id]['label'] = 'Premium Online Coaching';
    $payload['popular_style_id'] = $onlineStyle->id;

    $response = actingAs($coach)->put(route('coach.workout-styles.update'), $payload);

    $response->assertRedirect(route('coach.index'));
    $response->assertSessionHas('success');

    expect($onlineStyle->fresh()->label)->toBe('Premium Online Coaching')
        ->and($onlineStyle->fresh()->is_most_popular)->toBeTrue();
});

test('programs page reflects workout style source of truth', function () {
    WorkoutStyle::query()->update(['is_most_popular' => false]);
    $onlineStyle = WorkoutStyle::query()->where('key', 'online_coaching')->firstOrFail();
    $onlineStyle->update([
        'label' => 'Premium Online Coaching',
        'is_most_popular' => true,
    ]);

    $programsPage = get(route('programs'));
    $programsPage->assertOk();
    $programsPage->assertSee('Premium Online Coaching');
    $programsPage->assertSee('Most popular');
});
