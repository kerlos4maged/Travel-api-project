<?php

namespace App\Http\Requests\admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class AdminToursRequest extends FormRequest
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
            //
            // "travels_id" => "required|numeric",
            'name' => 'required|string',
            'starting_date' => 'required|string',
            'ending_date' => 'required|string',
            'price' => 'required|numeric',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            // "travels_id" => "id isn't valid",
            'name' => "name isn't valid",
            'starting_date' => "starting date isn't valid",
            'ending_date' => "ending date isn't valid",
            'price' => "price isn't valid",
        ];
    }
}
