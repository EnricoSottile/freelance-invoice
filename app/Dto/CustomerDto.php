<?php

namespace App\Dto;

final class CustomerDto
{

    protected $full_name;
    protected $email;
    protected $phone;
    protected $vat_code;

    public function __construct(
        String $full_name,
        ?String $email,
        ?String $phone,
        ?String $vat_code
    ) {
        $this->full_name = $full_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->vat_code = $vat_code;
    }


    /**
     * Get the value of full_name
     */
    public function getFull_name() : String
    {
        return $this->full_name;
    }

    /**
     * Get the value of email
     */
    public function getEmail() : ?String
    {
        return $this->email;
    }

    /**
     * Get the value of phone
     */
    public function getPhone() : ?String
    {
        return $this->phone;
    }

    /**
     * Get the value of vat_code
     */
    public function getVat_code() : ?String
    {
        return $this->vat_code;
    }
}
