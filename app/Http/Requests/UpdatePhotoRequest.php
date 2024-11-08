<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePhotoRequest extends FormRequest
{
    protected array $statuses = ['published', 'draft'];

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
            'title' => ['required', 'string', 'min:10'],
            'status' => ['required', 'string', Rule::in($this->statuses)],
            'photo' => ['nullable', 'image',  'max:5120'],
        ];
    }

    /**
     * Set the attributes for localization.
     */
    public function attributes(): array
    {
        return [
            'title' => __('galleries.title.label'),
            'status' => __('galleries.status.label'),
            'photo' => __('galleries.photo.label'),
        ];
    }
}
