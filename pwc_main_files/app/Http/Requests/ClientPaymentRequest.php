<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientPaymentRequest extends FormRequest
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
			'client_id' => 'sometimes',
			'option' => 'sometimes',
			'option_two' => 'sometimes',
			'option_three' => 'sometimes',
			'option_four' => 'sometimes',
			'reason' => 'sometimes',
			'scope' => 'sometimes',
			'amount' => 'sometimes',
			'price_charge_one' => 'sometimes',
			'price_charge_two' => 'sometimes',
			'final_price' => 'sometimes',
        ];
    }
}
