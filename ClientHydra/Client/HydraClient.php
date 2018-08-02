<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Client;

use Stadline\LinkdataClient\ClientHydra\Adapter\GuzzleAdapter;
use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyManager;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Type\MethodType;
use Stadline\LinkdataClient\ClientHydra\Utils\Paginator;
use Stadline\LinkdataClient\ClientHydra\Utils\Serializator;
use Stadline\LinkdataClient\ClientHydra\Utils\UriConverter;

abstract class HydraClient implements HydraClientInterface
{
    private $headers;
    private $config;

    public function __construct(array $headers = [])
    {
        $this->headers = $headers;
        $this->config = $this->loadConfiguration();
    }

    public function getProxy(string $iri): ProxyObject
    {
        $proxyManager = new ProxyManager($this);

        return $proxyManager->getProxy($iri);
    }

    /**
     * @throws ClientHydraException
     */
    public function send(string $method, array $args)
    {
        $uriConverter = new UriConverter($this->config);
        $uri = $uriConverter->formatUri($method, $args);

        $serializator = new Serializator($this->config);
        $serializator->setClient($this);
        $requester = new GuzzleAdapter($this->config);
        $body = null;

        // Put or POST, make a serialization with the entity.
        if (\in_array($uri['method'], [MethodType::POST, MethodType::PUT], true) && \count($args[1]) > 0) {
            $body = $serializator->serialize($args[1][0]);
            $this->headers['Content-Type'] = 'application/json';
        }

        $requestResponse = $requester->makeRequest($uri['method'], $uri['uri'], $this->headers, $body);
        $content = $serializator->deserialize($requestResponse);

        // If we have to paginate result, process pagination
        if (1 < \count($content)) {
            $content = new Paginator($content);
        }

        return $content;
    }

    private function loadConfiguration(): array
    {
        $json = \file_get_contents(__DIR__.'/../Config/config.json');

        return \json_decode($json, true);
    }
}
