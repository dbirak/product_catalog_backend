<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditProductRequest extends FormRequest
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
        $productId = $this->route('id');

        return [
            'nazwa' => 'required|max:50|string|unique:products,name,'.$productId,
            'kod' => 'required|max:100|string',
            'zdjęcie' => 'image',
            'pdf' => 'mimes:pdf|max:4096',
            'kategoria' => 'required|integer|exists:categories,id',
        ];
    }
}
