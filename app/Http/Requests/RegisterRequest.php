<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\ContainsNumber;
use App\Rules\HasSpecialCharacter;
use App\Rules\PhoneVerified;
use App\Enums\AccountType;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|max:200|unique:users',
            'phone' => [
                'required',
                'regex:/^\+(\d{1,4})\d{7,14}$/', 
                new PhoneVerified
            ],
            'password'    => ['required', 'string', 'min:8', new HasSpecialCharacter, new ContainsNumber],
            'account_type' => ["required", "string", Rule::in(
                AccountType::_PERSONAL, 
                AccountType::_BUSINESS,
                AccountType::_3PL
            )],
            'country' => ['required', 'string']
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            response([
                'message' => $validator->errors()->first(),
                'error' => $validator->getMessageBag()->toArray()
            ], 422)
        );
    }
}
