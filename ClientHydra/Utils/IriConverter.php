<?php

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Type\UriType;

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

    /**
     * @return string|int
     */
    public function getObjectIdFromIri(string $iri)
    {
        return explode('/', $iri)[2];
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
        return $this->generateUri($className, ['filters' => $filters]);
    }

    public function generateObjectUri(string $className, $id): string
    {
        return $this->generateUri($className, ['id' => $id]);
    }

    protected function generateUri($className, $parameters = []): string
    {
        $uri = Inflector::pluralize($className);
        $filters = $this->formatFilters($parameters['filters'] && \count($parameters['filters']) > 0 ? $parameters['filters'] : '');

        $uri = \sprintf('%s/%s%s', $this->baseUri, Inflector::tableize($uri), $filters);

        if (isset($parameters['id'])) {
            $uri .= sprintf('/%s', $parameters['id']);
        }

        return $uri;
    }

    private function formatFilters($args): string
    {
        // item case
        if (!\is_array($args) && !\is_object($args)) {
            return null !== $args ? \sprintf('/%s', $args) : '';
        }

        // item case (object)
        if (\is_object($args)) {
            return \method_exists($args, 'getId') ? \sprintf('/%s', $args->{'getId'}()) : '';
        }

        // collection case
        if (!\array_key_exists(UriType::FILTERS, $args)) {
            return '';
        }

        $response = '?';

        foreach ($args[UriType::FILTERS] as $key => $filter) {
            $response .= \sprintf('%s=%s&', $key, $filter);
        }

        return \substr($response, 0, -1);
    }

    private function getClassShortName($classNameOrObject): string
    {
        $reflectionClass = new \ReflectionClass($classNameOrObject);

        return $reflectionClass->getShortName();
    }
}
