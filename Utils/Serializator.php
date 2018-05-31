<?php

declare(strict_types=1);

namespace Geonaute\LinkdataClient\Utils;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

abstract class Serializator
{
    private function getSerializer(): Serializer
    {
        return SerializerBuilder::create()->build();
    }

    protected function serialize($object): string
    {
        $serializer = $this->getSerializer();
        return $serializer->serialize($object, 'json');
    }

    protected function deserialize(string $jsonData, string $className)
    {
        $serializer = $this->getSerializer();
        return $serializer->deserialize($jsonData, $className, 'json');
    }
}
