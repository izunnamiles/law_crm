<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCaseRequest extends FormRequest
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
            'client_type' => 'required|in:new,existing',
            'client_id' => 'nullable|required_if:client_type,existing|exists:clients,id',
            'first_name' => 'required_if:client_type,new',
            'last_name' => 'required_if:client_type,new',
            'email' => 'nullable|required_if:client_type,new|email|unique:clients,email',
            'date_of_birth' => 'nullable|required_if:client_type,new|date_format:Y-m-d',
            'date_profiled' => 'nullable|required_if:client_type,new|date_format:Y-m-d',
            'passport' => 'nullable|image|mimes:jpg,jpeg,png|max:5000',
            'counsel' => 'required|exists:counsels,id',
            'case_details' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.exists' => 'The selected client does not exist',
            'email.unique' => 'The provided email is tied to an existing client',
            'passport.max' => 'The maximum allowed file size is 5MB',
            'counsel.exists' => 'The selected counsel does not exist',
        ];
    }
}
