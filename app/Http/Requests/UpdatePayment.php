<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Dto\PaymentUpdateDto;

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
            'invoice_id' => 'required|exists:invoices,id',
            'net_amount' => 'required|between:0,99999999.99',
            'due_date' => 'nullable|date',
            'payed_date' => 'nullable|date'
        ];
    }

    /**
     *
     * @return PaymentUpdateDto
     */
    public function getDto() : PaymentUpdateDto
    {
        return new PaymentUpdateDto(
            $this->invoice_id,
            $this->net_amount,
            $this->due_date,        
            $this->payed_date    
        );
    }
}
