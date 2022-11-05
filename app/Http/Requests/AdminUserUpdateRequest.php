<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserUpdateRequest extends FormRequest
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
            'name' => 'required|string|unique:users,name,' . $this->user,
            'email' => 'required|string|unique:users,email,' . $this->user,
            'password' => 'required|string',
            'role_name' => 'required|string|exists:user_roles,name'
        ];
    }
}
