<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        $rules['name'] = 'required|unique:users';
        $rules['email'] = 'required|unique:users';
        $rules['password'] = 'required|min:8';
        $rules['role'] = 'required';

        if ( $this->request->get( 'id' ) ) {
            $id = $this->request->get( 'id' );

            // Remove password requirement if this is an update
            unset( $rules['password'] );

            // Update name rule to ignore the current record's id
            $rules['name'] = array(
                'required',
                Rule::unique( 'users', 'name' )->ignore( $id ),
            );

            // Update email rule to ignore the current record's id
            $rules['email'] = array(
                'required',
                Rule::unique( 'users', 'email' )->ignore( $id ),
            );
        }
        $rules['role'] = 'required';
        return $rules;
    }

    /**
     * Set the validation message.
     *
     * @return array
     */
    public function messages(): array {
        return array(
            'employee.required'  => 'The employee field is required.',
            'name.required'      => 'The user name field is required.',
            'password.required'  => 'The password field is required.',
            'password.min' => 'Password must be at least 8 characters',
            'role.required' => 'The organization list field is required.',
        );
    }
}
