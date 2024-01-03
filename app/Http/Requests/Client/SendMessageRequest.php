<?php

namespace App\Http\Requests\Client;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SendMessageRequest extends FormRequest
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
            'recipientId' => 'required|integer',
            'message' => 'required|string|max:255',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'recipientId.required' => 'Индивидуальный идентификатор получателя не должен быть пустым!',
            'recipientId.integer' => 'Индивидуальный идентификатор получателя должен быть числом!',
            'message.required' => 'Сообщение не должно быть пустым!',
            'message.string' => 'Сообщение должно быть строкой!',
            'message.max' => 'Сообщение не должно быть больше 255 символов!',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
