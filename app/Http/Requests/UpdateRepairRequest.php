<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRepairRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'truck_id'   => 'required|exists:trucks,id',
            'fault_id'      => 'required',
            'location'   => 'nullable|string|max:255',

        ];
    }
}
