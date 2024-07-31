<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ];
    }

//    public function messages(): array  //bu funksiyani custom olaraq mesagi deyishmek ucun istifade edirik
//    {
//        return [
//            'email.required' => 'Email mutleqdirrr',
//            'email.email' => 'Zehmet olmasa duz yazinn',
//        ];
//    }

//        public function attributes(): array   //lang papkasi icindeki fayllara gir attribute: menasini goreceksen
//        {
//            return[
//                'email' => 'Email',
//                'name' => 'Ad',
//                'surname' => 'Soyad',
//                'password' => 'Sifre',
//            ];
//        }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response([
            $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
