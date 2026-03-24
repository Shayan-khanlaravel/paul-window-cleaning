<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientScheduleRequest extends FormRequest
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
			'month' => 'sometimes',
			'week' => 'sometimes',
			'start_date' => 'sometimes',
			'end_date' => 'sometimes',
			'payment_type' => 'sometimes',
			'note' => 'sometimes',
        ];
    }
}
