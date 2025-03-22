<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name'=> 'sometimes|string',
            'description'=> 'sometimes|string',
            'quantity'=> 'sometimes|integer',
            'category_id'=> 'sometimes|integer|exists:categories,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.string'=> 'El nombre debe ser un texto',
            'description.string'=> 'La descripción debe ser un texto',
            'quantity.integer'=> 'La cantidad debe ser un número entero',
            'category_id.integer'=> 'La categoría debe ser un número entero',
            'category_id.exists'=> 'La categoría no existe',
        ];
    }
}
