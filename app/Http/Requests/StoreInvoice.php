<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoice extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'number' => 'required|string',
            'net_amount' => 'required|between:0,99999999.99',
            'tax' => 'required|between:0,100.00',
            'description' => 'nullable',
            'date' => 'nullable|date',
            'sent_date' => 'nullable|date',
            'registered_date' => 'nullable|date',
        ];
    }
}
