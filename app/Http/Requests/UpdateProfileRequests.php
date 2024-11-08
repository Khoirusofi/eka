<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequests extends FormRequest
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
                'required', 
                'numeric', 
                'digits:16', // Menggunakan 'digits' untuk memastikan panjang 16 digit
                Rule::unique('patients')->ignore(request()->user()->patient?->id),
            ],
            'phone' => [
                'required', 
                'numeric', 
                'digits_between:10,13', // Menggunakan 'digits_between' untuk panjang antara 10 hingga 13 digit
                Rule::unique('patients')->ignore(request()->user()->patient?->id),
            ],
            'address' => ['required', 'string', 'min:10', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'birth_place' => ['required', 'string', 'min:3', 'max:255'],
            'gender' => ['required', 'string', Rule::in(['male', 'female'])],
            'blood_type' => ['required', 'string', Rule::in(['A', 'B', 'AB', 'O'])], // Tambahkan aturan untuk golongan darah
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
            'blood_type' => __('patients.blood_type.label'), // Tambahkan atribut untuk golongan darah
        ];
    }
}
