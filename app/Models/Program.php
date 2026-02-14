<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'duration_weeks'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workouts(): HasMany
    {
        return $this->hasMany(Workout::class)->orderBy('sort_order');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(ProgramAssignment::class);
    }
}
