<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReviewRequest extends FormRequest
{
    protected array $statuses = ['processing', 'approved', 'rejected'];

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
            'body' => ['required', 'string', 'min:40'],
            'action' => ['required', 'string', 'min:40'],
            'respond' => ['required', 'string', 'min:40'],
            'status' => ['required', 'string', Rule::in($this->statuses)],
        ];
    }

    /**
     * Set the attributes for localization.
     */
    public function attributes(): array
    {
        return [
            'body' => __('reviews.body.label'),
            'action' => __('reviews.action.label'),
            'respond' => __('reviews.respond.label'),
            'status' => __('reviews.status.label'),
        ];
    }
}
