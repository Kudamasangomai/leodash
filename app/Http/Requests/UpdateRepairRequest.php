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
            'fault'      => 'required|string',
            'status'     => 'required|in:pending,in_progress,completed,on_hold',
            'location'   => 'nullable|string|max:255',
        
        ];
    }
}
