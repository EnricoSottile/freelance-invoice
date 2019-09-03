<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Dto\PaymentDto;

use Illuminate\Validation\Rule;

class UpdatePayment extends FormRequest
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
            'invoice_id' => [
                'required',
                Rule::exists('invoices', 'id')->where(function ($query) {
                    $query->where('user_id', \Auth::user()->id);
                }),
            ],
            'net_amount' => 'required|numeric|between:0,99999999.99',
            'due_date' => 'nullable|date',
            'payed_date' => 'nullable|date'
        ];
    }

    /**
     *
     * @return PaymentDto
     */
    public function getDto() : PaymentDto
    {
        return new PaymentDto(
            $this->invoice_id,
            $this->net_amount,
            $this->due_date,        
            $this->payed_date    
        );
    }
}
