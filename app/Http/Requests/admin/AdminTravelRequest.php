<?php

namespace App\Http\Requests\admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Override;

class AdminTravelRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'is_public' => ['required', 'boolean'],
            'name' => ['required', 'unique:travels'],
            'description' => ['required'],
            'number_of_days' => ['required', 'integer'],
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'message' => 'Validation Faild',
            'is_public' => 'is_public is required and must be a boolean value',
            'name' => 'name is required and must be unique',
            'description' => 'description is required',
            'number_of_days' => 'number_of_days is required and must be an integer',
        ];
    }

    #[Override]
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Fail in validation',
            'errors' => $validator->errors(),
        ], 422));
    }
}
