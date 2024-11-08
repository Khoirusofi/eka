<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:8', 'max:255'],
            'description' => ['required', 'string', 'min:40'],
            'price' => ['required', 'numeric', 'min:10000'],
            'photo' => ['required', 'image', 'max:2048'],
        ];
    }

    /**
     * Set the attributes for localization.
     */
    public function attributes(): array
    {
        return [
            'title' => __('services.title.label'),
            'description' => __('services.description.label'),
            'price' => __('services.price.label'),
            'photo' => __('services.photo.label'),
        ];
    }
}
