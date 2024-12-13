<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginPostRequest extends FormRequest
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
            'email' => 'required|string|email',
            'password' => 'required|string'
        ];
    }

    public function messages(): array
    {
            return[

                'email.required'=>'O campo email é Obrigatorio',
                'email.string'=>'O email deve ser um texto valido',
                'password.required'=>'O campo senha é Obrigatorio',
                'password.min'=>'A senha deve conter no minimo 8 caracteres',
            ];
    }
}
