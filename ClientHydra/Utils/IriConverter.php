<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;

class IriConverter
{
    private $baseUri;
    private $entityNamespace;
    private $classNameIdTypes;

    public function __construct(string $entityNamespace, string $baseUri = '')
    {
        $this->entityNamespace = $entityNamespace;
        $this->baseUri = $baseUri;
        $this->classNameIdTypes = [];
    }

    public function getIriFromObject(ProxyObject $object): ?string
    {
        if (!$object->getId()) {
            return null;
        }

        return \sprintf('%s/%s/%s', $this->baseUri, Inflector::tableize(Inflector::pluralize($this->getClassShortName($object))), $object->getId());
    }

    public function getIdTypeFromClassName(string $className): string
    {
        if (isset($this->classNameIdTypes[$className])) {
            return $this->classNameIdTypes[$className];
        }

        $reflectionClass = new \ReflectionClass($className);

        // Special case : method setId exists so, we must to cast the id in needed type
        if ($reflectionClass->hasMethod('setId')) {
            $reflectionMethod = $reflectionClass->getMethod('setId');
            $reflectionParameter = $reflectionMethod->getParameters()[0];

            $this->classNameIdTypes[$className] = $reflectionParameter->getType()->getName();

            return $this->classNameIdTypes[$className];
        }

        return $this->classNameIdTypes[$className] = 'unknown';
    }

    /**
     * @return int|string
     */
    public function getObjectIdFromIri(string $iri)
    {
        $id = \explode('/', \substr($iri, \strlen($this->baseUri)))[2];

        switch ($this->getIdTypeFromClassName($this->getClassnameFromIri($iri))) {
            case 'string':
                $id = (string) \explode('/', \substr($iri, \strlen($this->baseUri)))[2];
                break;
            case 'float':
                $id = (float) $id;
                break;
            case 'int':
                $id = (int) $id;
                break;
        }

        return $id;
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
        return $this->entityNamespace.'\\'.Inflector::classify(Inflector::singularize(\explode('/', $iri)[2]));
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
            if ($filter instanceof ProxyObject) {
                $filter = $this->getIriFromObject($filter);
                $response .= \sprintf('%s=%s&', $key, $filter);
            } elseif (is_array($filter)) {
                foreach ($filter as $arrayVal) {
                    $response .= \sprintf('%s[]=%s&', $key, $arrayVal);
                }
            } else {
                $response .= \sprintf('%s=%s&', $key, $filter);
            }
        }

        return \substr($response, 0, -1);
    }

    private function getClassShortName($classNameOrObject): string
    {
        if (\is_object($classNameOrObject) && $classNameOrObject instanceof ProxyObject) {
            $reflectionClass = new \ReflectionClass($classNameOrObject);
        } elseif (\is_string($classNameOrObject)) {
            if (!\class_exists($classNameOrObject)) {
                $classNameOrObject = \sprintf('%s\\%s', $this->entityNamespace, $classNameOrObject);
            }
            $reflectionClass = new \ReflectionClass($classNameOrObject);
        } else {
            throw new \RuntimeException('Invalid parameter for getClassShortName');
        }

        return $reflectionClass->getShortName();
    }

    public function isIri(string $str): bool
    {
        return 1 === \preg_match('@^'.$this->baseUri.'/([a-zA-Z0-9_]+)/([a-zA-Z0-9\-_])+$@', $str);
    }
}
