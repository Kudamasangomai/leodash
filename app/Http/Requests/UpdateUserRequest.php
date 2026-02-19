<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(User $user)
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

            'name' => 'required|max:50',
            'password'  => 'nullable',
            'email' => [
                'required',
                'string',
                'email',
                'max:50',
                Rule::unique(User::class)->ignore($this->user),
                'role' => 'nullable',


            ],
            'work_email' => [
                'required',
                'email',
                'max:50',
                Rule::unique(User::class)->ignore($this->user),
            ],
        ];
    }
}
