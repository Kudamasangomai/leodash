<?php

namespace App\Http\Requests;

use App\Enums\FaultUnitLocation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateFaultyUnitRequest extends FormRequest
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
            'serial_number' => ['required',Rule::unique('faulty_units', 'serial_number')
                ->ignore($this->route('faultyunit')),],
            'location'      => ['required', new Enum(FaultUnitLocation::class)],
            'comment'      => 'nullable',
            'fault'      => 'required',
            'unit_type'      => 'required',
        ];
    }
}
