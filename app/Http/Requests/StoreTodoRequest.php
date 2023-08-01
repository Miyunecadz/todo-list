<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
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
        return [
            'parent_id' => ['nullable', 'integer', 'exists:todos,id'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'datetime_start' => ['required', 'date'],
            'datetime_end' => ['required', 'date'],
            'created_by' => ['required', 'integer', 'exists:users,id']
        ];
    }
}
