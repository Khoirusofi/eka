<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
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
            'nik' => [
                'required', 'numeric', 'min_digits:16', 'max_digits:16',
                Rule::unique('patients', 'nik')->ignore($this->route('patient')->id)
            ],
            'phone' => [
                'required', 'numeric', 'min_digits:10', 'max_digits:13',
                Rule::unique('patients', 'phone')->ignore($this->route('patient')->id)
            ],
            'address' => ['required', 'string', 'min:10', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'birth_place' => ['required', 'string', 'min:10', 'max:255'],
            'gender' => ['required', 'string', Rule::in(['male', 'female'])],
        ];
    }


    /**
     * Set the attributes for localization.
     */
    public function attributes(): array
    {
        return [
            'nik' => __('patients.nik.label'),
            'phone' => __('patients.phone.label'),
            'address' => __('patients.address.label'),
            'birth_date' => __('patients.birth_date.label'),
            'birth_place' => __('patients.birth_place.label'),
            'gender' => __('patients.gender.label'),
        ];
    }
}
