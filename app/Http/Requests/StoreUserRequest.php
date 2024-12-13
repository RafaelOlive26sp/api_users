<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        $rules =  [
            'name'=> ['required','string','max:255','regex:/^[a-zA-ZÀ-ÿ\s]+$/u'],
            'email'=>'required|string|unique:users,email',
            'password'=>'required|min:8',
        ];

        if ($this->isMethod('patch') || $this->isMethod('post')) {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password']='required|string|min:8';
        }

        return $rules;


    }

    public function messages(): array
    {
        return[
            'name.required'=>'O campo nome é Obrigatorio',
            'name.string'=>'O nome deve ser um texto',
            'name.regex'=>'O nome deve conter apenas letras.',
            'email.required'=>'O campo email é Obrigatorio',
            'email.string'=>'O email deve ser um texto valid',
            'email.unique'=>'Este email ja esta em uso!',
            'password.required'=>'O campo senha é Obrigatorio',
            'password.min'=>'A senha deve conter no minimo 8 caracteres',

        ];
    }
}
