<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title_uz' => 'sometimes|required|string|max:255',
            'title_ru' => 'sometimes|required|string|max:255',
            'title_uzc' => 'sometimes|required|string|max:255',
            'description_uz' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'description_uzc' => 'nullable|string', 
            'files' => 'nullable|array',
            'files.*' => '',
            'category_id' => 'sometimes|required|exists:categories,id',
        ];
    }
}
