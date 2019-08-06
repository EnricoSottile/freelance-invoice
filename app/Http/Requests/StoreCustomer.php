<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Dto\CustomerDto;

class StoreCustomer extends FormRequest
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
            'full_name' => 'required|string',
            'email' => 'email|nullable',
            'phone' => 'string|nullable',
            'vat_code' => 'string|nullable'
        ];
    }

    public function getDto() : CustomerDto
    {
        return new CustomerDto(
            $this->full_name,
            $this->email,
            $this->phone,
            $this->vat_code
        );
    }
}
