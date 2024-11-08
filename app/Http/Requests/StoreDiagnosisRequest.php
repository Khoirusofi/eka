<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiagnosisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ubah menjadi true agar request ini diizinkan
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
        'detail' => ['required', 'min:10'], // Field detail harus diisi dan minimal 10 karakter
    ];
}


    /**
     * Custom message for validation errors.
     */
    public function messages()
    {
        return [
            'detail.required' => 'Detail diagnosa harus diisi.',
            'detail.min' => 'Detail diagnosa harus memiliki minimal 10 karakter.',
        ];
    }
}
