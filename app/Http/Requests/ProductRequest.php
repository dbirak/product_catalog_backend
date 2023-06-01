<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nazwa' => 'required|max:30|string|unique:products,name',
            'kod' => 'required|max:30|string',
            'zdjęcie' => 'required|image',
            'pdf' => 'required|mimes:pdf|max:4096',
            'kategoria' => 'required|integer|exists:categories,id',
        ];
    }
}
