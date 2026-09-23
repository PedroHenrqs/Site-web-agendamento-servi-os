<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:255"],
            "description" => ["required", "string"],
            "price" => ["required", "regex:/^\d{1,6}([.,]\d{1,2})?$/"],
            "active" => ["sometimes", "boolean"],
        ];
    }

    public function messages(): array
    {
        return [
            "price.regex" => "Informe um preço válido, por exemplo: 80,00",
        ];
    }
}
