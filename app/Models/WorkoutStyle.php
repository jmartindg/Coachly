<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutStyle extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'label',
        'subtitle',
        'description',
        'hint',
        'bullets',
        'sort_order',
        'is_most_popular',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'bullets' => 'array',
            'is_most_popular' => 'boolean',
        ];
    }

    /**
     * @return array<string, array{label: string, subtitle: string, description: string, bullets: list<string>, hint: string, is_most_popular: bool}>
     */
    public static function defaultOptions(): array
    {
        return [
            'foundations' => [
                'label' => 'Foundations',
                'subtitle' => '8-week starter plan',
                'description' => 'Perfect if you are newer to strength training or coming back after a break and want clear structure without feeling overwhelmed.',
                'bullets' => [
                    '3x/week full-body strength',
                    'Simple nutrition guidelines',
                    'Weekly email check-ins',
                    'Exercise video library access',
                ],
                'hint' => 'Best for beginners or anyone rebuilding consistency.',
                'is_most_popular' => false,
            ],
            'online_coaching' => [
                'label' => '1:1 Online Coaching',
                'subtitle' => 'Ongoing month-to-month',
                'description' => 'Fully customized coaching with close support and accountability. Ideal if you want a coach in your corner adjusting the plan as life happens.',
                'bullets' => [
                    'Customized training plan (updated as needed)',
                    'Flexible, high-protein nutrition targets',
                    'Weekly video or voice check-ins',
                    'Ongoing chat support',
                    'Form checks via video',
                ],
                'hint' => 'Best for busy professionals who want simple, done-for-you structure.',
                'is_most_popular' => true,
            ],
            'hybrid_coaching' => [
                'label' => 'Hybrid Coaching',
                'subtitle' => 'In-person + online',
                'description' => 'Combines in-gym sessions with between-session support, so you get hands-on coaching plus structure for the rest of the week.',
                'bullets' => [
                    '2-4 in-person sessions per month',
                    'Online programming between sessions',
                    'Technique tune-ups and progress reviews',
                    'Access to the same app and resources as online clients',
                ],
                'hint' => 'Best for lifters who value in-person feedback.',
                'is_most_popular' => false,
            ],
        ];
    }
}
