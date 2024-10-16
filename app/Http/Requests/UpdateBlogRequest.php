<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Helpers\ResponseFormatter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateBlogRequest extends FormRequest
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
            'title' => ['required', Rule::unique('blogs')->ignore($this->blog->id)],
            'body'  => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            return ResponseFormatter::error(
            $validator->errors(),
            'Validation Error',422);
        }
    }
}
