<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BundleFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'original_price' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:published,draft,archived'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'images_delete' => ['nullable', 'array'],
            'images_delete.*' => ['integer'],
            'benefits' => ['nullable', 'array'],
            'benefits.*.icon' => ['nullable', 'string', 'max:50'],
            'benefits.*.text' => ['required_with:benefits.*', 'string', 'max:255'],
            'included_products' => ['nullable', 'array'],
            'included_products.*' => ['string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bundle name is required.',
            'price.required' => 'Price is required.',
            'price.integer' => 'Price must be a valid number.',
            'images.*.max' => 'Each image must not exceed 10MB.',
        ];
    }
}
