<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            "description"=> 'required |string',
            'content' => 'required|string',
            'mentor_id' => 'required|integer|exists:users,id',
            'category_id' => 'required|integer|exists:categories,id',
            'tags' => 'array', // Tags should be an array
            'tags.*' => 'integer|exists:tags,id',
            'thumbnail' => 'nullable|string'
        ];
    }
}
