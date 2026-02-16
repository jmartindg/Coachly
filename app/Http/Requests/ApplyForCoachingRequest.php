<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplyForCoachingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'workout_style_preferences' => ['required', 'array', 'min:1', 'max:3'],
            'workout_style_preferences.*' => ['string', Rule::in(User::workoutStyleKeys())],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'workout_style_preferences.required' => 'Choose at least one workout style.',
            'workout_style_preferences.array' => 'Workout style choices are invalid.',
            'workout_style_preferences.min' => 'Choose at least one workout style.',
            'workout_style_preferences.max' => 'You can choose up to 3 workout styles.',
            'workout_style_preferences.*.in' => 'One of the selected workout styles is invalid.',
        ];
    }
}
