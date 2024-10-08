<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $userId = $this->route('register');

        $rules['name'] = 'required|string|max:255';
        $rules['email'] = 'required|email|unique:users,email,' . $userId;
        $rules['password'] = 'required|min:8';

        if ( $this->request->get( 'id' ) ) {
            $id = $this->request->get('id');

            // Remove password requirement if this is an update
            unset($rules['password']);

            // Update name rule to ignore the current record's id
            $rules['name'] = array(
                'required',
                Rule::unique('users', 'name')->ignore($id),
            );

            // Update email rule to ignore the current record's id
            $rules['email'] = array(
                'required',
                Rule::unique('users', 'email')->ignore($id),
            );
        }
        return $rules;
    }

    public function messages(): array{
        return array([
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'This email has already been taken',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'user_type.required' => 'The organization list field is required.',
        ]);
    }
}
