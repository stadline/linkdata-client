<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\ClientHydra\Utils;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\src\ClientHydra\Exception\UriException\FormatException;

class UriConverter
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws FormatException
     */
    public function formatUri(string $method, array $args): array
    {
        $response = [];

        if (1 !== \preg_match('/^(?<method>[a-z]+)(?<className>[A-Za-z]+)$/', $method, $matches)) {
            throw new FormatException(\sprintf('The method %s is not recognized.', $method));
        }

        $response['method'] = $matches['method'];
        $this->validateClassByName($matches['className']);

        $response['uri'] = $this->generateUri($matches['className'], $args);

        return $response;
    }

    /**
     * @throws FormatException
     */
    public function validateClassByName(string $className): string
    {
        // first, try to get the singular class
        $class = Inflector::singularize($className);

        if (\class_exists(\sprintf('%s\%s', $this->config['entity_namespace'], $class))) {
            return $class;
        }

        // second, if singular class not found, try to get the class in the plural
        $class = Inflector::pluralize($className);

        if (\class_exists(\sprintf('%s\%s', $this->config['entity_namespace'], $class))) {
            return $class;
        }

        // third, if singular and plural class not found, try to parse it to retrieve the correct name
        $splitedClassName = $this->parse($className);
        \array_pop($splitedClassName);

        if (empty($splitedClassName)) {
            throw new FormatException('The class you try to retrieve does not exist.');
        }

        return $this->validateClassByName(\implode($splitedClassName));
    }

    private function parse(string $className): array
    {
        // get each part of the uri by uppercase
        return \preg_split('/(?=[A-Z])/', $className, 0, PREG_SPLIT_NO_EMPTY);
    }

    private function generateUri(string $className, array $args): string
    {
        $uri = Inflector::pluralize($className);
        $filters = $this->formatFilters($args[0]);

        return \sprintf('%s/%s%s', $this->config['base_url'], Inflector::tableize($uri), $filters);
    }

    private function formatFilters(?array $args): string
    {
        // item case
        if (!\is_array($args)) {
            return null !== $args ? \sprintf('/%s', $args) : '';
        }

        // collection case
        if (!\array_key_exists('filters', $args)) {
            return '';
        }

        $response = '?';

        foreach ($args['filters'] as $key => $filter) {
            $response .= \sprintf('%s=%s&', $key, $filter);
        }

        return \substr($response, 0, -1);
    }
}
