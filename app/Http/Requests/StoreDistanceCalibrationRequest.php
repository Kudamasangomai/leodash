<?php

namespace App\Http\Requests;

use App\Models\Truck;
use Illuminate\Foundation\Http\FormRequest;

class StoreDistanceCalibrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'trucks' => 'required|array|max:10',
            'trucks.*' => 'string',
            // 'trucks.*' => 'string|exists:trucks,unitname',

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $trucks = $this->input('trucks');

            if ($trucks && is_array($trucks)) {
                foreach ($trucks as $unitname) {
                    $unitname = trim($unitname);

                    if (!Truck::where('unitname', $unitname)->exists()) {
                        $validator->errors()->add('trucks', "Truck '{$unitname}' Not Found.");
                    }
                }
            }
        });
    }
}
