<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nama_depan'    => 'required',
            'nama_belakang' => 'required',
            'email'         => 'required|email|unique:users,kontak.email',
            'password'      => 'required',
            'c_password'    => 'required|same:password',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required|date',
        ];
    }
}
