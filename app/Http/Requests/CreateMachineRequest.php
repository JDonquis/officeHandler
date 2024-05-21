<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMachineRequest extends FormRequest
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
        return 
        [
            "code" => ['required'],
            "name" => ['required'],
            "brand" => ['required'],
            "model" => ['required'],
            "manufacturer" => ['required'],
            "serial_number" => ['required'],
            "photo" => ['sometimes','nullable','mimes:jpg,jpeg,png','max:5048'],
            "observation" => ['sometimes']
        ];
    }
}
