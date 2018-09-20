<?php

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;

class IriConverter
{
    private $baseUri = '/v2';
    private $uriResolver;

    public function __construct(UriResolver $uriResolver)
    {
        $this->uriResolver = $uriResolver;
    }

    public function getIriFromObject(ProxyObject $object): string
    {
        return sprintf('/%s/%s/%s', $this->baseUri, Inflector::pluralize($this->getClassShortName($object)), $object->getId());
    }

    public function getIriFromClassNameAndId(string $className, $id): string
    {
        return sprintf('/%s/%s/%s', $this->baseUri, Inflector::pluralize($this->getClassShortName($className)), $id);
    }

    public function getCollectionIriFromClassName(string $className, $id): string
    {
        return sprintf('/%s/%s', $this->baseUri, Inflector::pluralize($this->getClassShortName($className)));
    }

    public function getClassnameFromIri(string $iri): string
    {
        return Inflector::singularize(explode('/', $iri)[2]);
    }

    public function generateCollectionUri(string $className, array $filters = []): string
    {
        $this->generateUri();
    }

    public function generateObjectUri(string $className, $id): string
    {
        $this->generateUri();
    }

    protected function generateUri($parameters): string
    {

    }

    private function getClassShortName($classNameOrObject): string
    {
        $reflectionClass = new \ReflectionClass($classNameOrObject);

        return $reflectionClass->getShortName();
    }
}
