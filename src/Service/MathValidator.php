<?php

namespace App\Service;

use App\Exception\InvalidInputData;

class MathValidator
{
    /**
     * @throws InvalidInputData
     */
    public function validateNumbers($numbers): array
    {
        $arrNumbers = explode(',', $numbers);
        if (!is_array($arrNumbers)) {
            throw new InvalidInputData('invalidInputData', 'Invalid input data. Must be an array of numbers', 'Error', 400, ['numbers' => $numbers]);
        }
        $params = [];
        foreach ($arrNumbers as $number) {
            $isInteger = is_numeric($number) && is_int($number + 0);
            if (!$isInteger) {
                $params[] = [
                  'number' => $number,
                  'message' => 'Number must be integer'
                ];
            }
        }
        if (count($params) > 0) {
            throw new InvalidInputData('invalidInputData', 'Invalid input data', 'Error', 400, $params);
        }
        return $arrNumbers;
    }

    /**
     * @throws InvalidInputData
     */
    public function validateNumber($number): void
    {
        $isInteger = is_numeric($number) && is_int($number + 0);
        if (!$isInteger) {
            $params[] = [
                'number' => $number,
                'message' => 'Number must be integer'
            ];
            throw new InvalidInputData('invalidInputData', 'Invalid input data', 'Error', 400, $params);
        }
    }
}
