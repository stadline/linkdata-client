<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Stadline\LinkdataClient\ClientHydra\Client\HydraClientInterface;
use Stadline\LinkdataClient\ClientHydra\Exception\SerializerException\ConfigurationException;
use Stadline\LinkdataClient\ClientHydra\Exception\SerializerException\SerializerException;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Type\FormatType;
use Stadline\LinkdataClient\ClientHydra\Type\HydraType;
use Stadline\LinkdataClient\ClientHydra\Type\NormContextType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Serializator
{
    private $entityNamespace;
    private $client;

    public function __construct(string $entityNamespace)
    {
        $this->entityNamespace = $entityNamespace;
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
                [$this->getNormContext(\strtolower(\explode('\\', \get_class($object))[4]), NormContextType::DENORN)]
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

        // EntityName does not match, it's a custom action (We decode json).
        if (!$entityName) {
            return \json_decode($response, true);
        }

        $isCollectionResponse = $this->isCollectionResponse($response);
        $className = \sprintf('%s\%s', $this->entityNamespace, \ucfirst($entityName));

        if ($isCollectionResponse) {
            return $this->deserializeCollection($response, $className);
        }

        try {
            $item = $this->getSerializer()->deserialize(
                $response,
                $className,
                FormatType::JSON,
                [$this->getNormContext($entityName, NormContextType::NORM)]
            );

            if ($item instanceof ProxyObject) {
                $item->setClient($this->client);
            }

            return $item;
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
                $currentItem = $serializer->deserialize(
                    \json_encode($item),
                    $className,
                    FormatType::JSON,
                    [\sprintf('%s_norm', \strtolower(\explode('\\', $className)[4]))]
                );

                if ($currentItem instanceof ProxyObject) {
                    $currentItem->setClient($this->client);
                }

                $items[] = $currentItem;
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

        return HydraType::COLLECTION === $responseJson['@type'];
    }

    private function getNormContext($entity, string $context): string
    {
        return \sprintf('%s_%s', \strtolower($entity), $context);
    }

    /**
     * @throws ConfigurationException
     */
    private function supportEntity($object): bool
    {
        if (false === \strpos(\get_class($object), $this->entityNamespace)) {
            throw new ConfigurationException(\sprintf('Entity %s is not supported by Serializator', \get_class($object)));
        }

        return true;
    }

    public function setClient(HydraClientInterface $client): void
    {
        $this->client = $client;
    }

    public function hasNode(string $json, string $node): bool
    {
        $response = \json_decode($json, true);

        return \array_key_exists($node, $response);
    }

    public function getNodeValues(string $json, string $node): array
    {
        $response = \json_decode($json, true);

        return $response[$node];
    }
}
