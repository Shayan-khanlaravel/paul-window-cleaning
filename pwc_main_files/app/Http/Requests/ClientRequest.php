<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
			'user_id' => 'sometimes',
			'client_type' => 'sometimes',
			'payment_type' => 'sometimes',
			'service_frequncy' => 'sometimes',
			'start_date' => 'sometimes',
			'end_date' => 'sometimes',
			'start_hour' => 'sometimes',
			'end_hour' => 'sometimes',
			'price_type' => 'sometimes',
			'inside_cost' => 'sometimes',
			'outside_cost' => 'sometimes',
			'custom_cost' => 'sometimes',
			'cost_description' => 'sometimes',
			'front_image' => 'sometimes',
			'back_image' => 'sometimes',
			'additional_note' => 'sometimes',
        ];
    }
}
