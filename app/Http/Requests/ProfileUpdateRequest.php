<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [];

        // If name is present in request, validate it
        if ($this->has('name')) {
            $rules['name'] = ['required', 'string', 'max:255'];
        }

        // If email is present in request, validate it
        if ($this->has('email')) {
            $rules['email'] = ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)];
        }

        // Contact info fields (optional)
        $rules['phone'] = ['nullable', 'string', 'max:20'];
        $rules['birthday'] = ['nullable', 'date'];
        $rules['gender'] = ['nullable', 'in:male,female,other'];

        return $rules;
    }
}
