<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|min:10|max:10',
            // 'password' => 'required|string|min:6',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name.attribute' => 'nombre',
            'last_name.attribute' => 'apellidos',
            'email.attribute' => 'correo',
            'phone.attribute' => 'teléfono',
            'password.attribute' => 'contraseña',
            'password_confirmation.attribute' => 'confirmar contraseña',
            'address.attribute' => 'dirección',
            'state.attribute' => 'estado',
            'city.attribute' => 'ciudad',
            'postal_code.attribute' => 'código postal',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'La contraseña debe tener al menos 6 caracteres. Debe contener al menos 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial \&@.-$.'
        ];
    }
}
