<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CmsAboutRequest extends FormRequest
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
			'two_sub_section_one_description' => 'sometimes',
			'two_sub_section_one_link_one' => 'sometimes',
			'two_sub_section_one_link_two' => 'sometimes',
			'two_sub_section_two_heading' => 'sometimes',
			'two_sub_section_two_description' => 'sometimes',
			'two_sub_section_two_link_one' => 'sometimes',
			'two_sub_section_two_link_two' => 'sometimes',
			'two_sub_section_three_heading' => 'sometimes',
			'two_sub_section_three_description' => 'sometimes',
			'two_sub_section_three_link_one' => 'sometimes',
			'two_sub_section_three_link_two' => 'sometimes',
			'two_sub_section_four_heading' => 'sometimes',
			'two_sub_section_four_description' => 'sometimes',
			'two_sub_section_four_link_one' => 'sometimes',
			'two_sub_section_four_link_two' => 'sometimes',
			'two_sub_section_five_heading' => 'sometimes',
			'two_sub_section_five_description' => 'sometimes',
			'two_sub_section_five_link_one' => 'sometimes',
			'two_sub_section_five_link_two' => 'sometimes',
			'section_one_image' => 'sometimes',
			'two_sub_section_one_image' => 'sometimes',
			'two_sub_section_two_image' => 'sometimes',
			'two_sub_section_three_image' => 'sometimes',
			'two_sub_section_four_image' => 'sometimes',
			'two_sub_section_five_image' => 'sometimes',
			'two_sub_section_one_title' => 'sometimes',
			'two_sub_section_two_title' => 'sometimes',
			'two_sub_section_three_title' => 'sometimes',
			'two_sub_section_four_title' => 'sometimes',
			'two_sub_section_five_title' => 'sometimes',
        ];
    }
}
