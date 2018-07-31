<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Exception\UriException\FormatException;

class UriConverter
{
    private $baseUrl;
    private $entityNamespace;
    private $uriResolver;

    public function __construct(string $baseUrl, string $entityNamespace)
    {
        $this->baseUrl = $baseUrl;
        $this->entityNamespace = $entityNamespace;
        $this->uriResolver = new UriResolver();
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
        $this->uriResolver->validateClassByName($matches['className'], $this->config['entity_namespace']);

        $response['uri'] = $this->generateUri($matches['className'], $args);

        return $response;
    }

    private function generateUri(string $className, array $args): string
    {
        $uri = Inflector::pluralize($className);
        $filters = $this->formatFilters(\count($args) > 0 ? $args[0] : null);

        return \sprintf('%s/%s%s', $this->baseUrl, Inflector::tableize($uri), $filters);
    }

    private function formatFilters($args): string
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
