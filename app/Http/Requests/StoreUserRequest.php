<?php

namespace App\Http\Requests;

use App\Models\User;
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

        $userId = $this->route('user') ?? null;

        $rules =  [
            'name'=> ['sometimes','nullable','string','max:255','regex:/^[a-zA-ZÀ-ÿ\s]+$/u'],
            'email'=>'sometimes|nullable|string|email|unique:users,email,'. $userId,
            'password'=>'sometimes|nullable|min:8',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $userId = $this->route('user');

            $isAdmin = auth()->user()->privilege_id ===1;

            if ($isAdmin && $userId) {
                $user = User::find($userId);

                if ($user && $user->privilege_id === 1) {
                    $rules['privilege_id'] = ['prohibited'];
                }
            }else{
                $rules['privilege_id'] = ['sometimes','nullable','integer','in:2,3'];
            }
                $rules['email'] = 'nullable|string|email|unique:users,email,'. $userId;
        }

        return $rules;





    }

    public function messages(): array
    {
        $messages = [
            'name.required'=>'O campo nome é Obrigatorio',
            'name.string'=>'O nome deve ser um texto',
            'name.regex'=>'O nome deve conter apenas letras.',
            'email.required'=>'O campo email é Obrigatorio',
            'email.string'=>'O email deve ser um texto valid',
            'email.unique'=>'Este email ja esta em uso!',
            'password.required'=>'O campo senha é Obrigatorio',
            'password.min'=>'A senha deve conter no minimo 8 caracteres',

        ];

        return $messages;
    }
}
