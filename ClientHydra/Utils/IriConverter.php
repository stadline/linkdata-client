<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Doctrine\Common\Inflector\Inflector;
use GuzzleHttp\Handler\Proxy;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;

class IriConverter
{
    private $baseUri;
    private $entityNamespace;

    public function __construct(string $entityNamespace, string $baseUri = '')
    {
        $this->entityNamespace = $entityNamespace;
        $this->baseUri = $baseUri;
    }

    public function getIriFromObject(ProxyObject $object): string
    {
        return \sprintf('%s/%s/%s', $this->baseUri, Inflector::tableize(Inflector::pluralize($this->getClassShortName($object))), $object->getId());
    }

    /**
     * @return int|string
     */
    public function getObjectIdFromIri(string $iri)
    {
        return \explode('/', \substr($iri, \strlen($this->baseUri)))[2];
    }

    public function getEntityNamespace(): string
    {
        return $this->entityNamespace;
    }

    public function getIriFromClassNameAndId(string $className, $id): string
    {
        return \sprintf('%s/%s/%s', $this->baseUri, Inflector::tableize(Inflector::pluralize($this->getClassShortName($className))), $id);
    }

    public function getCollectionIriFromClassName(string $className): string
    {
        return \sprintf('%s/%s', $this->baseUri, Inflector::tableize(Inflector::pluralize($this->getClassShortName($className))));
    }

    public function getClassnameFromIri(string $iri): string
    {
        return $this->entityNamespace . '\\' . Inflector::classify(Inflector::singularize(\explode('/', $iri)[2]));
    }

    public function generateCollectionUri(string $className, array $filters = []): string
    {
        return \sprintf(
            '%s%s',
            $this->getCollectionIriFromClassName($className),
            $this->formatFilters($filters)
        );
    }

    private function formatFilters(array $filters = []): string
    {
        $response = '?';
        foreach ($filters as $key => $filter) {
            $response .= \sprintf('%s=%s&', $key, $filter);
        }

        return \substr($response, 0, -1);
    }

    private function getClassShortName($classNameOrObject): string
    {
        if (\is_object($classNameOrObject) && $classNameOrObject instanceof ProxyObject) {
            $reflectionClass = new \ReflectionClass($classNameOrObject);
        } elseif (\is_string($classNameOrObject)) {
            if (!class_exists($classNameOrObject)) {
                $classNameOrObject = \sprintf('%s\\%s', $this->entityNamespace, $classNameOrObject);
            }
            $reflectionClass = new \ReflectionClass($classNameOrObject);
        } else {
            throw new \RuntimeException('Invalid parameter for getClassShortName');
        }

        return $reflectionClass->getShortName();
    }
}
