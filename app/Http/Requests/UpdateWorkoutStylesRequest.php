<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkoutStylesRequest extends FormRequest
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
            'styles' => ['required', 'array', 'min:1'],
            'styles.*.label' => ['required', 'string', 'max:255'],
            'styles.*.subtitle' => ['required', 'string', 'max:255'],
            'styles.*.description' => ['required', 'string'],
            'styles.*.hint' => ['required', 'string', 'max:255'],
            'styles.*.bullets_text' => ['required', 'string'],
            'popular_style_id' => ['nullable', 'integer', 'exists:workout_styles,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'styles.required' => 'At least one workout style is required.',
            'styles.*.label.required' => 'Each workout style needs a name.',
            'styles.*.subtitle.required' => 'Each workout style needs a subtitle.',
            'styles.*.description.required' => 'Each workout style needs a description.',
            'styles.*.hint.required' => 'Each workout style needs a short hint.',
            'styles.*.bullets_text.required' => 'Each workout style needs bullet points.',
            'popular_style_id.exists' => 'The selected most popular style is invalid.',
        ];
    }
}
