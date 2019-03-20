<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

use Stadline\LinkdataClient\ClientHydra\Adapter\AdapterInterface;
use Stadline\LinkdataClient\ClientHydra\Adapter\JsonResponse;
use Stadline\LinkdataClient\ClientHydra\Utils\HydraParser;
use Stadline\LinkdataClient\ClientHydra\Utils\IriConverter;
use Symfony\Component\Serializer\SerializerInterface;

class ProxyManager
{
    private $adapter;
    private $iriConverter;
    private $serializer;

    /** @var ProxyObject[] */
    private $objects = [];

    public function __construct(
        AdapterInterface $adapter,
        IriConverter $iriConverter,
        SerializerInterface $serializer
    ) {
        $this->adapter = $adapter;
        $this->iriConverter = $iriConverter;
        $this->serializer = $serializer;
    }

    public function contains($object): bool
    {
        return in_array($object, $this->objects);
    }

    public function getObjectFromIri(string $iri): ?ProxyObject
    {
        $object = $this->getProxyFromIri($iri);
        if (null === $object) {
            return null;
        }

        return $object;
    }

    private function addObjectToManager(ProxyObject $proxyObject) {
        $proxyObject->_init(
            function (ProxyObject $proxyObject, $data): void {
                $this->serializer->deserialize(\json_encode($data), get_class($proxyObject), 'json', [
                    'object_to_populate' => $proxyObject,
                    'groups' => [HydraParser::getDenormContext($data)],
                ]);
            },
            function (ProxyObject $proxyObject): array {
                $requestResponse = $this->getAdapter()->makeRequest(
                    'GET',
                    $this->iriConverter->getIriFromObject($proxyObject)
                );

                if (!$requestResponse instanceof JsonResponse) {
                    throw new \RuntimeException('Cannot hydrate object with non json response');
                }

                return $requestResponse->getContent();
            }
        );
    }

    public function getProxyFromIri(string $iri): ?ProxyObject
    {
        // check if object already store
        if (isset($this->objects[$iri])) {
            return $this->objects[$iri];
        }

        $className = $this->iriConverter->getClassnameFromIri($iri);
        /** @var ProxyObject $proxyObject */
        $id = $this->iriConverter->getObjectIdFromIri($iri);
        $proxyObject = new $className();
        $proxyObject->setId($id);
        $this->addObjectToManager($proxyObject);
        $this->objects[$iri] = $proxyObject;

        return $proxyObject;
    }

    public function getObject(string $className, $id): ?ProxyObject
    {
        $iri = $this->iriConverter->getIriFromClassNameAndId($className, $id);

        return $this->getObjectFromIri($iri);
    }

    public function hasObject(string $iri): bool
    {
        // check if object already store
        return isset($this->objects[$iri]);
    }

    public function addObject(string $iri, ProxyObject $object): void
    {
        $this->addObjectToManager($object);
        $this->objects[$iri] = $object;
    }

    public function getCollection(string $classname, array $filters = []): ProxyCollection
    {
        return new ProxyCollection(
            $this,
            $this->iriConverter,
            $classname,
            $filters
        );
    }

    public function putObject(ProxyObject $object): ProxyObject
    {
        if (!$this->contains($object)) {
            throw new \RuntimeException('Object must be registred in ProxyManager before using PUT on it');
        }

        $response = $this->adapter->makeRequest(
            'PUT',
            $this->iriConverter->getIriFromObject($object),
            [],
            $this->serializer->serialize(
                $object,
                'json',
                ['groups' => [HydraParser::getNormContext($object)], 'classContext' => \get_class($object)]
            )
        );

        if (!$response instanceof JsonResponse) {
            throw new \RuntimeException('Error during update object');
        }

        $object->_refresh($response->getContent());

        return $object;
    }

    public function deleteObject(...$objectOrId): void
    {
        if (1 === \count($objectOrId) && $objectOrId[0] instanceof ProxyObject) {
            $iri = $this->iriConverter->getIriFromObject($objectOrId[0]);
        } elseif (2 === \count($objectOrId)) {
            $iri = $this->iriConverter->getIriFromClassNameAndId($objectOrId[0], $objectOrId[1]);
        } else {
            throw new \RuntimeException('Invalid input for deleteObject method');
        }

        $this->adapter->makeRequest(
            'DELETE',
            $iri
        );

        unset($this->objects[$iri]);
    }

    public function postObject(ProxyObject $object): ProxyObject
    {
        $this->addObjectToManager($object);

        $response = $this->adapter->makeRequest(
            'POST',
            $this->iriConverter->getCollectionIriFromClassName(\get_class($object)),
            [],
            $this->serializer->serialize(
                $object,
                'json',
                ['groups' => [HydraParser::getNormContext($object)], 'classContext' => \get_class($object)]
            )
        );

        if (!$response instanceof JsonResponse) {
            throw new \RuntimeException('Error during update object');
        }

        $object->setId($response->getContent()['id']);
        $object->_refresh($response->getContent());

        return $object;
    }

    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }
}
