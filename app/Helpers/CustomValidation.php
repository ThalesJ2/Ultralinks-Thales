<?php

namespace App\Helpers;

class CustomValidation
{
    public static function validateCep($cep)
    {
        $cep = str_replace("-", "", $cep);
        $cepPattern = '/^\d{5}(\d{3})?$/';

        return preg_match($cepPattern, $cep) === 1;
    }

    public static function validateNumber($number){

        if(is_integer($number) && $number >=1)
            return true;
    }

    public static function validateEmail($email){
        $emailAux = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        return preg_match($emailAux, $email['email']) === 1;
    }

}
