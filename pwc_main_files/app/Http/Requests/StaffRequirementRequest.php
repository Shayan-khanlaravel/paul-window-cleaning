<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequirementRequest extends FormRequest
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
			'staff_id' => 'sometimes',
			'name' => 'sometimes',
			'quantity' => 'sometimes',
			'description' => 'sometimes',
			'status' => 'sometimes',
        ];
    }
}
