<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Utils;

use Stadline\LinkdataClient\src\Exception\DeserializationException;
use Stadline\LinkdataClient\src\Exception\SerializationException;
use Stadline\LinkdataClient\src\Exception\SerializerConfigurationException;
use Stadline\LinkdataClient\src\Type\FormatType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Serializator
{
    private const HYDRA_COLLECTION_TYPE = 'hydra:Collection';
    private $config;

    public function __construct() {
        $this->config = $this->loadConfiguration();
    }

    /**
     * @throws SerializerConfigurationException
     */
    private function getSerializer(): Serializer
    {
        try {
            $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        } catch (\RuntimeException $e) {
            throw new SerializerConfigurationException('Unable to instantiate Serializer', $e);
        }

        return $serializer;
    }

    /**
     * @throws SerializationException
     * @throws SerializerConfigurationException
     */
    public function serialize($object): string
    {
        if (false === strpos(\get_class($object), $this->config->entity_namespace)) {
            throw new SerializerConfigurationException(\sprintf('Entity %s is not supported by Serializator', \get_class($object)));
        }

        $serializer = $this->getSerializer();

        try {
            return $serializer->serialize(
                $object,
                FormatType::JSON,
                [\sprintf('%s_denorm', \strtolower((new \ReflectionClass($object))->getShortName()))]
            );
        } catch (NotEncodableValueException $e) {
            throw new SerializationException(
                \sprintf('An error occurred during serialization with format %s', FormatType::JSON),
                $e
            );
        }
    }

    /**
     * @throws DeserializationException
     * @throws SerializationException
     * @throws SerializerConfigurationException
     */
    public function deserialize(string $response)
    {
        $entityName = $this->getEntityName($response);
        $isCollectionResponse = $this->isCollectionResponse($response);
        $className = \sprintf('%s%s', $this->config->entity_namespace, \ucfirst($entityName));

        if ($isCollectionResponse) {
            return $this->deserializeCollection($response, $className);
        }

        $serializer = $this->getSerializer();

        try {return $serializer->deserialize(
                $response,
                $className,
                FormatType::JSON,
                [\sprintf('%s_norm', \strtolower($entityName))]
            );
        } catch (NotEncodableValueException $e) {
            throw new DeserializationException(
                \sprintf('An error occurred during deserialization with format %s', FormatType::JSON),
                $e
            );
        }
    }

    /**
     * @throws SerializationException
     * @throws SerializerConfigurationException
     */
    private function deserializeCollection(string $response, string $className): array
    {
        $serializer = $this->getSerializer();
        $responseJson = \json_decode($response, true);
        $items = [];

        foreach ($responseJson['hydra:member'] as $item) {
            try {
                $items[] = $serializer->deserialize(\json_encode($item), $className, FormatType::JSON);
            } catch (NotEncodableValueException $e) {
                throw new SerializationException(
                    \sprintf('An error occurred during deserialization with format %s', FormatType::JSON),
                    $e
                );
            }
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

    private function loadConfiguration()
    {
        $json = file_get_contents(__DIR__.'/../Config/config.json');

        return json_decode($json);
    }
}
