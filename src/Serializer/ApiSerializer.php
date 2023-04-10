<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiSerializer
{
    public function getSerializer(): Serializer
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        return new Serializer($normalizers, $encoders);
    }

    public function serialize($data, string $format = 'json'): string
    {
        return $this->getSerializer()->serialize($data, $format);
    }

    public function deserialize(string $data, string $type, string $format = 'json')
    {
        return $this->getSerializer()->deserialize($data, $type, $format);
    }
}
