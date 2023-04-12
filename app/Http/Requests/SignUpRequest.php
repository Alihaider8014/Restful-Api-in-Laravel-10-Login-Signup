<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class SignUpRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:6|max:255|alpha',
            'last_name'  => 'required|string|min:6|max:255|alpha',
            'source'     => 'nullable|in:api,backoffice',
            'password'   => ['required', 'confirmed', Password::default()],
            'email'      => 'required|email|unique:users,email',
            'dob'        => 'required|date_format:Y-m-d|before:'.now()->subYears(18)->toDateString()
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'A first name field is required',
            'last_name.required' => 'A last name field is required',
            'password.required' => 'A password field is required',
            'email.required' => 'A email field is required',
            'email.unique' => 'A email is not unique',
            'dob.required' => 'A dob field is required',
        ];
    }
    /**
     * Handle a passed validation attempt.
     * if you need to normalize any request data after validation is complete.
     * you may use the passedValidation method.
     */
    protected function passedValidation(): void
    {
        $this->replace(['source' => 'API']);
    }
}
