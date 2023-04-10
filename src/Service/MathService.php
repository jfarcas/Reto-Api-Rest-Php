<?php

namespace App\Service;

class MathService
{
    public function getLeastCommonMultiple(array $listOfNumbers): int
    {
        $max = max($listOfNumbers);
        $leastCommonMultiple = $max;

        while (true) {
            $isDivisible = true;
            foreach ($listOfNumbers as $number) {
                if ($leastCommonMultiple % $number !== 0) {
                    $isDivisible = false;
                    break;
                }
            }
            if ($isDivisible) {
                return $leastCommonMultiple;
            }
            $leastCommonMultiple += $max;
        }
    }

    public function incrementNumber(int $number, int $increment): int
    {
        return $number  + $increment;
    }
}
