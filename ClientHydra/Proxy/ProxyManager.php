<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Adapter\AdapterInterface;
use Stadline\LinkdataClient\ClientHydra\Client\HydraClientInterface;
use Stadline\LinkdataClient\ClientHydra\Utils\IriConverter;
use Symfony\Component\Serializer\SerializerInterface;

class ProxyManager
{
    private $adapter;
    private $objects = [];
    private $hydraClient;
    private $iriConverter;
    private $serializer;

    public function __construct(
        HydraClientInterface $hydraClient,
        AdapterInterface $adapter,
        IriConverter $iriConverter,
        SerializerInterface $serializer
    )
    {
        $this->hydraClient = $hydraClient;
        $this->adapter = $adapter;
        $this->iriConverter = $iriConverter;
        $this->serializer = $serializer;
    }

    public function getObjectFromIri(string $iri): ?ProxyObject
    {
        // check if object already store
        if (isset($this->objects[$iri])) {
            return $this->objects[$iri];
        }

        $proxyObject = new ProxyObject(
            $this->iriConverter,
            $this->serializer,
            $this,

        );
        $proxyObject->

        // resolve method to call.
//        $methodToCall = \ucfirst(Inflector::singularize(\explode('/', $iri)[2]));
//        $tempMethodToCall = 'get';
//
//        if (-1 !== \strstr('_', $methodToCall)) {
//            foreach (\explode('_', $methodToCall) as $part) {
//                if ('get' !== $part) {
//                    $tempMethodToCall .= \ucfirst(Inflector::singularize($part));
//                }
//            }
//
//            $methodToCall = $tempMethodToCall;
//        }
//
//        $id = \explode('/', $iri)[3];
//
//        // call client to resolve proxy.
//        $object = $this->hydraClient->send($methodToCall, [$id]);
        $objects[$iri] = $object;

        return $object;
    }

    public function getObject(string $className, $id): ?ProxyObject
    {
        $iri = $this->iriConverter->getIriFromClassNameAndId($className, $id);
        return $this->getObjectFromIri($iri);
    }

//    public function getObject(string $iri): ProxyObject
//    {
//        // check if object already store
//        if (isset($this->objects[$iri])) {
//            return $this->objects[$iri];
//        }
//
//        // resolve method to call.
//        $methodToCall = \ucfirst(Inflector::singularize(\explode('/', $iri)[2]));
//        $tempMethodToCall = 'get';
//
//        if (-1 !== \strstr('_', $methodToCall)) {
//            foreach (\explode('_', $methodToCall) as $part) {
//                if ('get' !== $part) {
//                    $tempMethodToCall .= \ucfirst(Inflector::singularize($part));
//                }
//            }
//
//            $methodToCall = $tempMethodToCall;
//        }
//
//        $id = \explode('/', $iri)[3];
//
//        // call client to resolve proxy.
//        $object = $this->hydraClient->send($methodToCall, [$id]);
//        $objects[$iri] = $object;
//
//        return $object;
//    }

    public function hasObject(string $iri): bool
    {
        // check if object already store
        return isset($this->objects[$iri]);
    }

    public function addObject(string $iri, ProxyObject $object): void
    {
        $this->objects[$iri] = $object;
    }

    public function getCollection(string $classname, array $filters = []): ProxyCollection
    {
        return new ProxyCollection(
            $this,
            $this->serializer,
            $this->iriConverter,
            $classname,
            $filters
        );
    }

    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }
}
