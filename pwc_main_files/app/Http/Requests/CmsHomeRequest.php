<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CmsHomeRequest extends FormRequest
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
			'two_sub_section_one_heading' => 'sometimes',
			'two_sub_section_one_title' => 'sometimes',
			'two_sub_section_two_heading' => 'sometimes',
			'two_sub_section_two_title' => 'sometimes',
			'section_three_heading' => 'sometimes',
			'section_three_description' => 'sometimes',
			'three_sub_section_one_heading' => 'sometimes',
			'three_sub_section_one_description' => 'sometimes',
			'three_sub_section_one_link' => 'sometimes',
			'section_two_image_one' => 'sometimes',
			'section_two_image_two' => 'sometimes',
			'two_sub_section_one_icon' => 'sometimes',
			'two_sub_section_two_icon' => 'sometimes',
			'three_sub_section_one_image' => 'sometimes',
        ];
    }
}
