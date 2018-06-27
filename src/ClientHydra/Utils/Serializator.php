<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\ClientHydra\Utils;

use ReflectionException;
use Stadline\LinkdataClient\src\ClientHydra\Exception\SerializerException\ConfigurationException;
use Stadline\LinkdataClient\src\ClientHydra\Exception\SerializerException\SerializerException;
use Stadline\LinkdataClient\src\ClientHydra\Type\FormatType;
use Stadline\LinkdataClient\src\ClientHydra\Type\NormContextType;
use Stadline\LinkdataClient\src\Linkdata\Proxy\ProxyObject;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Serializator
{
    private const HYDRA_COLLECTION_TYPE = 'hydra:Collection';
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws ConfigurationException
     */
    private function getSerializer(): Serializer
    {
        try {
            $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        } catch (\RuntimeException $e) {
            throw new ConfigurationException('Unable to instantiate Serializer', $e);
        }

        return $serializer;
    }

    /**
     * @throws SerializerException
     */
    public function serialize($object): string
    {
        $this->supportEntity($object);
        $serializer = $this->getSerializer();

        try {
            return $serializer->serialize(
                $object,
                FormatType::JSON,
                [$this->getNormContext($object, NormContextType::DENORN)]
            );
        } catch (NotEncodableValueException $e) {
            throw new SerializerException(
                \sprintf('An error occurred during serialization with format %s', FormatType::JSON),
                $e
            );
        }
    }

    /**
     * @throws SerializerException
     */
    public function deserialize(string $response)
    {
        $entityName = $this->getEntityName($response);
        $isCollectionResponse = $this->isCollectionResponse($response);
        $className = \sprintf('%s\%s', $this->config['entity_namespace'], \ucfirst($entityName));

        if ($isCollectionResponse) {
            return $this->deserializeCollection($response, $className);
        }

        $serializer = $this->getSerializer();

        try {
            return $serializer->deserialize(
                $response,
                $className,
                FormatType::JSON,
                [$this->getNormContext($entityName, NormContextType::NORM)]
            );
        } catch (NotEncodableValueException $e) {
            throw new SerializerException(
                \sprintf('An error occurred during deserialization with format %s', FormatType::JSON),
                $e
            );
        }
    }

    /**
     * @throws SerializerException
     */
    private function deserializeCollection(string $response, string $className): array
    {
        $serializer = $this->getSerializer();
        $responseJson = \json_decode($response, true);
        $items = [];

        foreach ($responseJson['hydra:member'] as $item) {
            try {
                /* @var ProxyObject $currentItem */
                $items[] = $serializer->deserialize(
                    \json_encode($item),
                    $className,
                    FormatType::JSON,
                    [\sprintf('%s_norm', \strtolower(\explode('\\', $className)[4]))]
                );
            } catch (NotEncodableValueException $e) {
                throw new SerializerException(
                    \sprintf('An error occurred during deserialization with format %s', FormatType::JSON),
                    $e
                );
            }
        }

        return $items;
    }

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

    /**
     * @throws ConfigurationException
     */
    private function getNormContext($entity, string $context): string
    {
        try {
            return \sprintf('%s_%s', \strtolower($entity), $context);
        } catch (ReflectionException $e) {
            $entityName = \is_string($entity) ? $entity : \get_class($entity);
            throw new ConfigurationException(\sprintf('Unable to retrieve entity %s in %s context', $entityName, $context));
        }
    }

    /**
     * @throws ConfigurationException
     */
    private function supportEntity($object): bool
    {
        if (false === \strpos(\get_class($object), $this->config['entity_namespace'])) {
            throw new ConfigurationException(\sprintf('Entity %s is not supported by Serializator', \get_class($object)));
        }

        return true;
    }
}
