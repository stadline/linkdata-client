<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Exception\UriException\FormatException;
use Stadline\LinkdataClient\ClientHydra\Type\UriType;

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
        $this->uriResolver->validateClassByName($matches['className'], $this->entityNamespace);

        $response['uri'] = $this->generateUri($matches['className'], $args);

        return $response;
    }

    private function generateUri(string $className, array $args): string
    {
        $uri = Inflector::pluralize($className);
        $filters = $this->formatFilters(\count($args) > 0 ? $args[0] : '');

        return \sprintf('%s/%s%s', $this->baseUrl, Inflector::tableize($uri), $filters);
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

    public function getUriParam(string $needle, string $uri): ?string
    {
        $query = \parse_url($uri, PHP_URL_QUERY);

        if (null === $query) {
            return null;
        }

        \parse_str($query, $output);

        return $output[$needle] ?? null;
    }

    public function addUriParam(string $key, string $value, string &$uri): void
    {
        $url = \parse_url($uri);

        if (!\array_key_exists('query', $url) || null === $url['query']) {
            $output = [$key => $value];
        } else {
            \parse_str($url['query'], $output);
            $output = \array_merge($output, [$key => $value]);
        }

        $url['query'] = \http_build_query($output);

        $response = '';

        foreach ($url as $part) {
            if ($url['scheme'] === $part) {
                $response .= \sprintf('%s://', $part);
            } elseif ($url['query'] === $part) {
                $response .= \sprintf('?%s', $part);
            } else {
                $response .= $part;
            }
        }

        $uri = $response;
    }

    public function updateUriParamValue(string $key, string $value, string &$uri): void
    {
        $url = \parse_url($uri);

        \parse_str($url['query'], $output);
        $output[$key] = $value;

        $url['query'] = \http_build_query($output);

        $response = '';

        foreach ($url as $part) {
            if ($url['scheme'] === $part) {
                $response .= \sprintf('%s://', $part);
            } elseif ($url['query'] === $part) {
                $response .= \sprintf('?%s', $part);
            } else {
                $response .= $part;
            }
        }

        $uri = $response;
    }
}
