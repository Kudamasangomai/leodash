<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDistanceCalibrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'truck' => ['required', 'string'],
            'date_created' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'date_went_to_roadtest' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'road_test_done' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
