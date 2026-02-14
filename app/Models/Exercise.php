<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exercise extends Model
{
    /** @use HasFactory<\Database\Factories\ExerciseFactory> */
    use HasFactory;

    protected $fillable = ['workout_id', 'name', 'sets', 'reps', 'rest_seconds', 'notes', 'sort_order'];

    public function workout(): BelongsTo
    {
        return $this->belongsTo(Workout::class);
    }
}
