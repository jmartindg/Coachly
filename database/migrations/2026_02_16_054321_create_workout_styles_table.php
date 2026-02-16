<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workout_styles', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->string('subtitle');
            $table->text('description');
            $table->text('hint');
            $table->json('bullets');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $defaultStyles = [
            [
                'key' => 'foundations',
                'label' => 'Foundations',
                'subtitle' => '8-week starter plan',
                'description' => 'Perfect if you are newer to strength training or coming back after a break and want clear structure without feeling overwhelmed.',
                'hint' => 'Best for beginners or anyone rebuilding consistency.',
                'bullets' => json_encode([
                    '3x/week full-body strength',
                    'Simple nutrition guidelines',
                    'Weekly email check-ins',
                    'Exercise video library access',
                ], JSON_THROW_ON_ERROR),
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'online_coaching',
                'label' => '1:1 Online Coaching',
                'subtitle' => 'Ongoing month-to-month',
                'description' => 'Fully customized coaching with close support and accountability. Ideal if you want a coach in your corner adjusting the plan as life happens.',
                'hint' => 'Best for busy professionals who want simple, done-for-you structure.',
                'bullets' => json_encode([
                    'Customized training plan (updated as needed)',
                    'Flexible, high-protein nutrition targets',
                    'Weekly video or voice check-ins',
                    'Ongoing chat support',
                    'Form checks via video',
                ], JSON_THROW_ON_ERROR),
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'hybrid_coaching',
                'label' => 'Hybrid Coaching',
                'subtitle' => 'In-person + online',
                'description' => 'Combines in-gym sessions with between-session support, so you get hands-on coaching plus structure for the rest of the week.',
                'hint' => 'Best for lifters who value in-person feedback.',
                'bullets' => json_encode([
                    '2-4 in-person sessions per month',
                    'Online programming between sessions',
                    'Technique tune-ups and progress reviews',
                    'Access to the same app and resources as online clients',
                ], JSON_THROW_ON_ERROR),
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('workout_styles')->insert($defaultStyles);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_styles');
    }
};
