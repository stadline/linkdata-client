<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Client;

use Stadline\LinkdataClient\ClientHydra\Adapter\AdapterInterface;
use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyManager;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Type\MethodType;
use Stadline\LinkdataClient\ClientHydra\Utils\Paginator;
use Stadline\LinkdataClient\ClientHydra\Utils\Serializator;
use Stadline\LinkdataClient\ClientHydra\Utils\UriConverter;

abstract class HydraClient implements HydraClientInterface
{
    private $adapter;
    private $uriConverter;
    private $serializator;
    private $headers;
    private $baseUrl;

    public function __construct(
        AdapterInterface $adapter,
        UriConverter $uriConverter,
        Serializator $serializator,
        array $headers,
        string $baseUrl
    ) {
        $this->adapter = $adapter;
        $this->uriConverter = $uriConverter;
        $this->serializator = $serializator;
        $this->headers = $headers;
        $this->baseUrl = $baseUrl;
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

        $requestResponse = $this->adapter->makeRequest($uri['method'], $this->baseUrl, $uri['uri'], $this->headers, $body);
        $content = $this->serializator->deserialize($requestResponse);

        // If we have to paginate result, process pagination
        if (1 < \count($content)) {
            $content = new Paginator($content);
        }

        return $content;
    }
}
