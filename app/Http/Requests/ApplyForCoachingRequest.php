<?php

namespace App\Http\Requests;

use App\Enums\ClientStatus;
use App\Enums\Role;
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
        $timeSlots = array_map(
            static fn (int $h): string => sprintf('%02d:00', $h),
            range(8, 18)
        );

        return [
            'workout_style_preferences' => ['required', 'array', 'min:1', 'max:3'],
            'workout_style_preferences.*' => ['string', Rule::in(User::workoutStyleKeys())],
            'appointment_date' => ['nullable', 'date', 'after_or_equal:today', 'required_with:appointment_time'],
            'appointment_time' => [
                'nullable',
                'string',
                Rule::in($timeSlots),
                'required_with:appointment_date',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (! $this->filled('appointment_date')) {
                        return;
                    }
                    $alreadyBooked = User::query()
                        ->where('role', Role::Client)
                        ->whereIn('client_status', [ClientStatus::Pending, ClientStatus::Applied])
                        ->whereDate('appointment_date', $this->input('appointment_date'))
                        ->where('appointment_time', $value)
                        ->where('id', '!=', $this->user()->id)
                        ->exists();
                    if ($alreadyBooked) {
                        $fail('This time slot is already booked for the selected date.');
                    }
                },
            ],
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
            'appointment_date.after_or_equal' => 'The appointment date must be today or a future date.',
            'appointment_date.required_with' => 'Please select a date when choosing a time.',
            'appointment_time.required_with' => 'Please select a time when choosing a date.',
            'appointment_time.in' => 'The selected time is invalid.',
        ];
    }
}
