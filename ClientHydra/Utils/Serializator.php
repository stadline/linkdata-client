<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Stadline\LinkdataClient\ClientHydra\Adapter\JsonResponse;
use Stadline\LinkdataClient\ClientHydra\Exception\ConfigurationException;
use Stadline\LinkdataClient\ClientHydra\Exception\SerializerException;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyCollection;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyManager;
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
    private $proxyManager;
    private $serializer;

    public function __construct(string $entityNamespace, ProxyManager $proxyManager)
    {
        $this->entityNamespace = $entityNamespace;
        $this->proxyManager = $proxyManager;

        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    /**
     * @throws SerializerException
     */
    public function serialize(ProxyObject $object): string
    {
        $this->supportEntity($object);

        try {
            $object->setHydrated(false);
            $item = $this->serializer->serialize(
                $object,
                FormatType::JSON,
                [$this->getNormContext(\strtolower(\explode('\\', \get_class($object))[4]), NormContextType::DENORN)]
            );
            $object->setHydrated(true);

            return $item;
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
    public function deserialize(JsonResponse $response, array $context = [])
    {
        // EntityName does not match, it's a custom action (We decode json).
        if (!$entityName = $response->getEntityName()) {
            return $response->getContent();
        }

        $className = \sprintf('%s\%s', $this->entityNamespace, \ucfirst($entityName));

        if ($response->isCollection()) {
            return $this->deserializeCollection($response, $className, $context);
        }

        return $this->deserializeObject($response, $className, $context);
    }

    /**
     * @throws SerializerException
     */
    public function deserializeObject(JsonResponse $response, string $className, array $context = []): ProxyObject
    {
        try {
            $item = $this->serializer->deserialize(
                \json_encode($responseJson),
                $className,
                FormatType::JSON,
                [$this->getNormContext(\explode('\\', $className)[4], NormContextType::NORM)]
            );

            if (!$item instanceof ProxyObject) {
                throw new \RuntimeException('Deserialize object must be a ProxyObject instance');
            }

            $this->proxyManager->addObject($className, $item);

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
    private function deserializeCollection(JsonResponse $response, string $className, array $context = []): ProxyCollection
    {
        $collection = new ProxyCollection();

        try {
            foreach ($responseJson['hydra:member'] as $item) {
                $items[] = $this->deserializeObject($item, $className);
            }
        } catch (NotEncodableValueException $e) {
            throw new SerializerException(
                \sprintf('An error occurred during deserialization with format %s', FormatType::JSON),
                $e
            );
        }

        return $collection;
    }

    private function getEntityName(array $responseJson): ?string
    {
        if (!isset($responseJson['@context'])) {
            return null;
        }

        return \explode('/', $responseJson['@context'])[3] ?? null;
    }

    private function isCollectionResponse(array $responseJson): bool
    {
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

    public function hasNode(array $response, string $node): bool
    {
        return \array_key_exists($node, $response);
    }

    public function getNodeValues(array $response, string $node): array
    {
        return $response[$node];
    }
}
