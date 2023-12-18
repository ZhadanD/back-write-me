<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'role' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Имя пользователя не должно быть пустым!',
            'name.string' => 'Имя должно быть строкой!',
            'name.max' => 'Имя должно быть меньше 255 символов!',
            'email.required' => 'Почта пользователя не должна быть пустой!',
            'email.string' => 'Почта должна быть строкой!',
            'email.max' => 'Почта должна быть меньше 255 символов!',
            'email.email' => 'Напишите пожалуйста свою почту!!!',
            'email.unique' => 'Такая почта уже существует!',
            'role.required' => 'Роль пользователя не должна быть пустой!',
            'role.string' => 'Роль должна быть строкой!',
            'role.max' => 'Роль должна быть меньше 255 символов!',
            'password.required' => 'Пароль пользователя не должен быть пустым!',
            'password.string' => 'Пароль должен быть строкой!',
            'password.max' => 'Пароль должен быть меньше 255 символов!',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
