<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CmsServiceRequest extends FormRequest
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
			'section_one_heading' => 'sometimes',
			'section_one_description' => 'sometimes',
			'section_two_heading' => 'sometimes',
			'section_two_description' => 'sometimes',
			'section_one_image' => 'sometimes',
			'section_two_image' => 'sometimes',
        ];
    }
}
