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

abstract class AbstractHydraClient implements HydraClientInterface
{
    private $uriConverter;
    private $serializator;
    private $requestHandler;
    private $headers;

    private $baseUrl;

    public function __construct(string $baseUrl, int $maxResultPerPage, string $entityNamespace)
    {
        // Header default value
        $this->headers = [
            'Content-Type' => 'application/ld+json',
        ];

        $this->baseUrl = $baseUrl;

        $this->uriConverter = new UriConverter($this->baseUrl, $entityNamespace);
        $this->serializator = new Serializator($entityNamespace);
        $paginationHandler = new PaginationHandler($this->serializator, $this->uriConverter, $maxResultPerPage);

        $adapter = new GuzzleAdapter();
        $this->requestHandler = new RequestHandler($adapter, $this->serializator, $paginationHandler);
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
        if (isset($args['customUri'])) {
            $uri['uri'] = \sprintf('%s%s', $this->baseUrl, $args['customUri']);
            $uri['method'] = $method;
        } else {
            $uri = $this->uriConverter->formatUri($method, $args);
        }

        $this->serializator->setClient($this);
        $body = null;

        // Put or POST, make a serialization with the entity.
        if (isset($args[0]) && \in_array($uri['method'], [MethodType::POST, MethodType::PUT], true)) {
            $body = $this->serializator->serialize(MethodType::POST === $uri['method'] ? $args[0][0] : $args[0]);
        }

        $requestArgs = [
            'method' => $uri['method'],
            'baseUrl' => $this->baseUrl,
            'uri' => $uri['uri'],
            'headers' => $this->headers,
            'body' => $body,
        ];

        return $this->requestHandler->handleRequest($requestArgs);
    }

    /**
     * @throws ClientHydraException
     */
    public function __call(string $method, array $args)
    {
        return $this->send($method, $args);
    }

    public function setHeader(string $name, ?string $value): void
    {
        if (null !== $value) {
            $this->headers[$name] = $value;
        } else {
            unset($this->headers[$name]);
        }
    }
}
