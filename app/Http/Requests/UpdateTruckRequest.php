<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTruckRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $truckId = $this->route('truck') ? $this->route('truck')->id : null;

        return [
            'unitname' => [
                'required',
                'string',
                'max:255',
                Rule::unique('trucks', 'unitname')->ignore($truckId),
            ],

            'status' => ['required'],
            'make' => ['required'],

        ];
    }
}
