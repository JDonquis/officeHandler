<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MantenimientoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
        'machine_id' => ['required'],
        'type_service_id' => ['required'],
        'user_id' => ['required'],
        'start' => ['required'],
        'description' => ['sometimes', 'nullable'],
        'status' => ['required'],
        'duration' => ['sometimes', 'nullable'],
        'end' => ['sometimes', 'nullable'],
        'next_service_date' => ['sometimes', 'nullable'],
        ];
    }
}
