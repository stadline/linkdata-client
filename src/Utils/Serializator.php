<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Utils;

use Stadline\LinkdataClient\src\Exception\SerializatorException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Serializator
{
    const HYDRA_COLLECTION_TYPE = 'hydra:Collection';

    private function getSerializer(): Serializer
    {
        return new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    public function serialize($object): string
    {
        if (!\strstr(\get_class($object), 'Stadline\LinkdataClient\src\Entity')) {
            throw new SerializatorException(\sprintf('Entity %s is not supported by Serializator', \get_class($object)));
        }

        return $this->getSerializer()->serialize(
            $object,
            'json',
            [\sprintf('%s_denorm', \strtolower((new \ReflectionClass($object))->getShortName()))]
        );
    }

    public function deserialize(string $response)
    {
        $entityName = $this->getEntityName($response);
        $isCollectionResponse = $this->isCollectionResponse($response);
        $className = \sprintf('Stadline\\LinkdataClient\\src\\Entity\\%s', \ucfirst($entityName));

        if ($isCollectionResponse) {
            // passer les groupes de norm.
            return $this->deserializeCollection($response, $className);
        }

        return $this->getSerializer()->deserialize(
            $response,
            $className,
            'json',
            [\sprintf('%s_norm', \strtolower($entityName))]
        );
    }

    private function deserializeCollection(string $response, string $className): array
    {
        $responseJson = \json_decode($response, true);
        $items = [];

        foreach ($responseJson['hydra:member'] as $item) {
            $items[] = $this->getSerializer()->deserialize(\json_encode($item), $className, 'json');
        }

        return $items;
    }

    /**
     * Parse JsonLD type to get entity name.
     *
     * @param string $response
     *
     * @return string
     */
    private function getEntityName(string $response): string
    {
        $responseJson = \json_decode($response, true);

        return \explode('/', $responseJson['@context'])[3];
    }

    private function isCollectionResponse(string $response): bool
    {
        $responseJson = \json_decode($response, true);

        return self::HYDRA_COLLECTION_TYPE === $responseJson['@type'];
    }
}
