<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user')->id;

        return [
            "first_name" => "required",
            "last_name" => "required",
            "password" => "nullable",
            "username" => [
                "required",
                Rule::unique('users', 'username')->ignore($userId),
                siteSetting()['usernameValidate']
            ],
            "role" => "required|in:" . join(',', roles()),
        ];
    }
}
