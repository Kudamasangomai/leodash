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

            'trucks' => 'required|array',
            'trucks.*' => 'string',
            // 'date_went_to_roadtest' => ['nullable', 'date'],
            // 'road_test_done' => ['nullable', 'boolean'],
            // 'notes' => ['nullable', 'string'],
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
                $validator->errors()->add('trucks', "Truck '{$unitname}' not found in the system.");
            }
        }
    }
});

    }

    /**
     * Get the validated data and parse trucks CSV into array.
     */
    // public function validated($key = null, $default = null)
    // {
    //     $data = parent::validated($key, $default);

    //     if (isset($data['trucks']) && is_string($data['trucks'])) {
    //         $trucksArray = array_filter(array_map('trim', explode(',', $data['trucks'])));
    //         $data['trucks'] = $trucksArray;
    //     }

    //     if (!isset($data['created_by'])) {
    //         $data['created_by'] = auth()->id();
    //     }

    //     return $data;
    // }
}
