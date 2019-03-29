<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Client;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Adapter\AdapterInterface;
use Stadline\LinkdataClient\ClientHydra\Adapter\JsonResponse;
use Stadline\LinkdataClient\ClientHydra\Adapter\ResponseInterface;
use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\ClientHydra\Exception\FormatException;
use Stadline\LinkdataClient\ClientHydra\Metadata\MetadataManager;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyCollection;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Utils\HydraParser;
use Stadline\LinkdataClient\ClientHydra\Utils\IriConverter;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractHydraClient implements HydraClientInterface
{
    private $adapter;
    private $iriConverter;
    private $serializer;

    /** @var ProxyObject[] */
    private $objects = [];

    public function __construct(
        AdapterInterface $adapter,
        IriConverter $iriConverter,
        SerializerInterface $serializer,
        MetadataManager $metadataManager
    )
    {
        $this->adapter = $adapter;
        $this->iriConverter = $iriConverter;
        $this->serializer = $serializer;

        ProxyObject::_init(
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
            },
            function ($className, $id) {
                return $this->getObject($className, $id, false);
            },
            $metadataManager
        );
    }

    public function contains($object): bool
    {
        return \in_array($object, $this->objects, true);
    }

    protected function getProxyFromIri(string $iri, ?bool $autoHydrate = false): ?ProxyObject
    {
        // check if object not already store
        if (!isset($this->objects[$iri])) {
            $className = $this->iriConverter->getClassnameFromIri($iri);
            /** @var ProxyObject $proxyObject */
            $id = $this->iriConverter->getObjectIdFromIri($iri);
            $proxyObject = new $className();
            $proxyObject->setId($id);
            $this->objects[$iri] = $proxyObject;
        } else {
            $proxyObject = $this->objects[$iri];
        }

        if (true === $autoHydrate) {
            $proxyObject->_hydrate();
        }

        return $proxyObject;
    }

    /**
     * @return $className
     */
    public function getObject(string $className, $id, ?bool $autoHydrate = false): ?ProxyObject
    {
        if (!is_string($id) || !$this->iriConverter->isIri($id)) {
            $id = $this->iriConverter->getIriFromClassNameAndId($className, $id);
        }
        return $this->getProxyFromIri($id, $autoHydrate);
    }

    /**
     * @return ProxyObject|ProxyCollection|null
     */
    protected function parseResponse(ResponseInterface $response)
    {
        if (!$response instanceof JsonResponse || !isset(($elt = $response->getContent())['@type'])) {
            return null;
        }

        /* Collection case */
        if ($elt['@type'] === 'hydra:Collection') {
            return new ProxyCollection(
                $this,
                $elt
            );
        }

        /* Object case */
        if (!$elt['@id']) {
            throw new \RuntimeException('Method getObjectFromResponse only support object or collection');
        }

        $object = $this->getProxyFromIri($elt['@id'], false);
        if (null === $object) {
            throw new \RuntimeException(sprintf('Cannot create object with iri : %s', $elt['@id']));
        }

        $object->_refresh($elt);
        return $object;
    }

    public function addObject(string $iri, ProxyObject $object): void
    {
        $this->objects[$iri] = $object;
    }

    public function getCollection(string $classname, array $filters = []): ProxyCollection
    {
        return new ProxyCollection(
            $this,
            [
                'hydra:view' => [
                    'hydra:next' => $this->iriConverter->generateCollectionUri($classname, $filters)
                ]
            ]
        );
    }

    public function putObject(ProxyObject $object): ProxyObject
    {
        if (!$this->contains($object)) {
            throw new \RuntimeException('Object must be registered in HydraClient before using PUT on it');
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

    /**
     * @throws ClientHydraException
     * @deprecated
     */
    public function __call(string $method, array $args)
    {
        if (1 !== \preg_match('/^(?<method>[a-z]+)(?<className>[A-Za-z]+)$/', $method, $matches)) {
            throw new FormatException(\sprintf('The method %s is not recognized.', $method));
        }

        $method = \strtolower($matches['method']);
        $className = Inflector::singularize($matches['className']);

        switch ($method) {
            case 'get':
                // collection case
                if (!isset($args[0]) || \is_array($args[0])) {
                    return $this->getCollection($className, $args[0]['filters'] ?? []);
                }

                // item (string | int) case
                if (\is_int($args[0]) || \is_string($args[0])) {
                    return $this->getObject($className, $args[0], false);
                }

                throw new \RuntimeException('Unknown error during call get');
            case 'put':
                if (!$args[0] instanceof ProxyObject) {
                    throw new \RuntimeException('Put require a proxy object in parameter');
                }

                return $this->putObject($args[0]);
            case 'delete':
                if (!\is_string($args[0]) || !\is_int($args[0])) {
                    throw new \RuntimeException('Delete require a string or an int in parameter');
                }

                $this->deleteObject($className, $args[0]);

                return null;
            case 'post':
                if (!$args[0] instanceof ProxyObject) {
                    throw new \RuntimeException('Post require a proxy object in parameter');
                }

                return $this->postObject($args[0]);
        }

        throw new \RuntimeException('Cannot determine method to call');
    }
}
