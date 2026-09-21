<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "service_id" => ["required", "exists:services,id"],
            "date" => ["required", "date_format:Y-m-d"],
            "time" => ["required", "date_format:H:i"],
        ];
    }
}
