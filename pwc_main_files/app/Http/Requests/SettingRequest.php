<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
			'title' => 'sometimes',
			'description' => 'sometimes',
			'favicon' => 'sometimes',
			'logo' => 'sometimes',
			'footer_text' => 'sometimes',
			'facebook' => 'sometimes',
			'twitter' => 'sometimes',
			'youtube' => 'sometimes',
			'instagram' => 'sometimes',
			'whatsapp' => 'sometimes',
			'stripe_publishable' => 'sometimes',
			'stripe_secret' => 'sometimes',
        ];
    }
}
