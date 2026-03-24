<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffMemberRequest extends FormRequest
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
        return
        [
			'name' => 'sometimes',
			'email' => 'sometimes',
			'password' => 'sometimes',
			'address' => 'sometimes',
			'dob' => 'sometimes',
			'image' => 'sometimes',
			'phone' => 'sometimes',
        ];
    }
}
