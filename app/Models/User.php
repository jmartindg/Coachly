<?php

namespace App\Models;

use App\Enums\ClientStatus;
use App\Enums\Role;
use App\Enums\Sex;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'client_status',
        'last_approved_at',
        'age',
        'sex',
        'height',
        'weight',
        'mobile_number',
        'workout_style_preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
            'client_status' => ClientStatus::class,
            'last_approved_at' => 'datetime',
            'sex' => Sex::class,
            'workout_style_preferences' => 'array',
        ];
    }

    /**
     * @return array<string, array{label: string, subtitle: string, description: string, bullets: list<string>, hint: string, is_most_popular: bool}>
     */
    public static function workoutStyleOptions(): array
    {
        if (! Schema::hasTable('workout_styles')) {
            return WorkoutStyle::defaultOptions();
        }

        $styles = WorkoutStyle::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($styles->isEmpty()) {
            return WorkoutStyle::defaultOptions();
        }

        return $styles
            ->mapWithKeys(static fn (WorkoutStyle $style): array => [
                $style->key => [
                    'label' => $style->label,
                    'subtitle' => $style->subtitle,
                    'description' => $style->description,
                    'bullets' => $style->bullets ?? [],
                    'hint' => $style->hint,
                    'is_most_popular' => (bool) $style->is_most_popular,
                ],
            ])
            ->all();
    }

    /**
     * @return list<string>
     */
    public static function workoutStyleKeys(): array
    {
        return array_keys(self::workoutStyleOptions());
    }

    /**
     * @return list<string>
     */
    public function workoutStylePreferenceLabels(): array
    {
        $options = self::workoutStyleOptions();

        return collect($this->workout_style_preferences ?? [])
            ->map(static fn (string $key): ?string => $options[$key]['label'] ?? null)
            ->filter()
            ->values()
            ->all();
    }

    public function isCoach(): bool
    {
        return $this->role === Role::Coach;
    }

    public function isClient(): bool
    {
        return $this->role === Role::Client;
    }

    public function isLead(): bool
    {
        return $this->role === Role::Client && $this->client_status === ClientStatus::Lead;
    }

    public function isApplied(): bool
    {
        return $this->role === Role::Client && $this->client_status === ClientStatus::Applied;
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function programAssignments(): HasMany
    {
        return $this->hasMany(ProgramAssignment::class);
    }

    public function assignedPrograms(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_assignments')
            ->withPivot('assigned_at')
            ->withTimestamps();
    }

    public function currentProgram(): ?Program
    {
        $assignmentsQuery = $this->programAssignments()
            ->with('program.workouts.exercises')
            ->orderByDesc('assigned_at')
            ->orderByDesc('id');

        if ($this->last_approved_at) {
            $assignmentsQuery->where('assigned_at', '>=', $this->last_approved_at);
        }

        $assignment = $assignmentsQuery->first();

        return $assignment?->program;
    }
}
