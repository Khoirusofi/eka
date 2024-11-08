<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
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
            'body' => ['required', 'string', 'min:120'],
            'excerpt' => ['required', 'string', 'min:40'],
            'status' => ['required', 'string', Rule::in($this->statuses)],
            'photo' => ['nullable', 'image', 'max:2048'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('articles', 'slug')->ignore($this->article),
            ],
            'category_id' => ['required', 'exists:categories,id'], // Add validation for category_id
        ];
    }

    /**
     * Set the attributes for localization.
     */
    public function attributes(): array
    {
        return [
            'title' => __('articles.title.label'),
            'body' => __('articles.body.label'),
            'excerpt' => __('articles.excerpt.label'),
            'status' => __('articles.status.label'),
            'photo' => __('articles.photo.label'),
            'slug' => __('articles.slug.label'),
            'category_id' => __('articles.category.label'), // Add localization for category_id
        ];
    }
}
