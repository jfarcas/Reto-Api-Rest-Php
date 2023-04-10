<?php

namespace App\Service;

class RandomTypeGenerator
{
    public function generateRandomType(): string
    {
        $types = ['chuck', 'dad'];
        return $types[array_rand($types)];
    }
}
