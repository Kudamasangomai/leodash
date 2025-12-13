<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTruckRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unitname' => ['required', 'string', 'max:255', 'unique:trucks,unitname'],
            'license_plate' => ['nullable', 'string', 'max:50'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer'],
            'vin' => ['nullable', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer'],
            'color' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:active,inactive,maintenance'],
            'purchased_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
