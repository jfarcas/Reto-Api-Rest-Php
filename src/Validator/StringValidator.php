<?php

namespace App\Validator;

class StringValidator
{
    public function validate($inputData): bool
    {
        return is_string($inputData);
    }
}
