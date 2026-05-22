<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ToursRequest extends FormRequest
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
            'priceFrom' => 'numeric',
            'priceTo' => 'numeric',
            'dateFrom' => 'date',
            'dateTo' => 'date',
            'sortBy' => Rule::in(['price']),
            'sortOrder' => Rule::in(['asc', 'desc']),
        ];
    }

    public function messages(): array
    {
        return [
            'priceFrom.numeric' => 'The priceFrom field must be a number.',
            'priceTo.numeric' => 'The priceTo field must be a number.',
            'dateFrom.date' => 'The dateFrom field must be a valid date.',
            'dateTo.date' => 'The dateTo field must be a valid date.',
            'sortBy.in' => 'The sortBy field must be either "price".',
            'sortOrder.in' => 'The sortOrder field must be either "asc" or "desc".',
        ];
    }
}
