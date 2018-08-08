<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Client;

use Stadline\LinkdataClient\ClientHydra\Adapter\GuzzleAdapter;
use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\ClientHydra\Handler\PaginationHandler;
use Stadline\LinkdataClient\ClientHydra\Handler\RequestHandler;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyManager;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Type\MethodType;
use Stadline\LinkdataClient\ClientHydra\Utils\Serializator;
use Stadline\LinkdataClient\ClientHydra\Utils\UriConverter;

abstract class HydraClient implements HydraClientInterface
{
    private $uriConverter;
    private $serializator;
    private $requestHandler;
    private $headers;
    private $config;

    public function __construct(array $headers)
    {
        $this->config = $this->loadConfiguration();
        $this->uriConverter = new UriConverter($this->config['base_url'], $this->config['entity_namespace']);
        $this->serializator = new Serializator($this->config['entity_namespace']);
        $paginationHandler = new PaginationHandler($this->serializator, $this->uriConverter, $this->config['max_result_per_page']);

        $adapter = new GuzzleAdapter();
        $this->requestHandler = new RequestHandler($adapter, $this->serializator, $paginationHandler);
        $this->headers = $headers;
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
        $uri = $this->uriConverter->formatUri($method, $args);
        $this->serializator->setClient($this);
        $body = null;

        // Put or POST, make a serialization with the entity.
        if (\in_array($uri['method'], [MethodType::POST, MethodType::PUT], true) && \count($args[1]) > 0) {
            $body = $this->serializator->serialize($args[1][0]);
            $this->headers['Content-Type'] = 'application/json';
        }

        $requestArgs = [
            'method' => $uri['method'],
            'baseUrl' => $this->config['base_url'],
            'uri' => $uri['uri'],
            'headers' => $this->headers,
            'body' => $body,
        ];

        return $this->requestHandler->handleRequest($requestArgs);
    }

    private function loadConfiguration(): array
    {
        $json = \file_get_contents(__DIR__.'/../Config/config.json');

        return \json_decode($json, true);
    }
}
