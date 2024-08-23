<?php

namespace App\Http\Requests\Teacher;

use App\Utils\Api\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

class CourseCreateRequest extends FormRequest
{
    use ApiResponse;
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
            'title' => 'required|string|max:60',
            'categories' => 'array|required',
            'categories.*' => 'required|exists:categories,id',
        ];
    }

    protected function  failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response =$this->validationResponse($validator->errors());

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
