<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Utils;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Serializator
{
    const HYDRA_COLLECTION_TYPE = 'hydra:Collection';

    private function getSerializer(): Serializer
    {
        return new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    protected function serialize($object): string
    {
        $serializer = $this->getSerializer();
        return $serializer->serialize($object, 'json');
    }

    public function deserialize(string $response)
    {
        $entityName = $this->getEntityName($response);
        $isCollectionResponse = $this->isCollectionResponse($response);
        $className = sprintf('Stadline\\LinkdataClient\\src\\Entity\\%s', ucfirst($entityName));

        if ($isCollectionResponse) {
            return $this->deserializeCollection($response, $className);
        }

        return $this->getSerializer()->deserialize(
            $response,
            $className,
            'json'
        );
    }

    private function deserializeCollection(string $response, string $className): array
    {
        $responseJson = json_decode($response, true);
        $items = [];

        foreach ($responseJson['hydra:member'] as $item) {
            $items[] = $this->getSerializer()->deserialize(json_encode($item), $className, 'json');
        }

        return $items;
    }

    /**
     * Parse JsonLD type to get entity name
     *
     * @param string $response
     * @return string
     */
    private function getEntityName(string $response): string
    {
        $responseJson = json_decode($response, true);

        return explode('/', $responseJson['@context'])[3];
    }

    private function isCollectionResponse(string $response): bool
    {
        $responseJson = json_decode($response, true);

        return $responseJson['@type'] === self::HYDRA_COLLECTION_TYPE;
    }
}
