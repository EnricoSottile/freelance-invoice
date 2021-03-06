<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Dto\InvoiceDto;

use Illuminate\Validation\Rule;

class UpdateInvoice extends FormRequest
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
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where(function ($query) {
                    $query->where('user_id', \Auth::user()->id);
                }),
            ],
            'number' => 'required|string|max:100',
            'net_amount' => 'required|numeric|between:0,99999999.99',
            'tax' => 'required|numeric|between:0,100.00',
            'description' => 'nullable|max:300',
            'date' => 'nullable|date',
            'sent_date' => 'nullable|date',
            'registered_date' => 'nullable|date',
        ];
    }


    public function getDto() : InvoiceDto 
    {
        return new InvoiceDto(
            $this->customer_id,
            $this->number,
            $this->net_amount,
            $this->tax,
            $this->description,
            $this->date,
            $this->sent_date,
            $this->registered_date
        );
    }
}
