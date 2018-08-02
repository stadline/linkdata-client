<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Client;

use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
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

    public function __construct(
        UriConverter $uriConverter,
        Serializator $serializator,
        RequestHandler $requestHandler,
        array $headers
    ) {
        $this->uriConverter = $uriConverter;
        $this->serializator = $serializator;
        $this->requestHandler = $requestHandler;
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
            'uri' => $uri['uri'],
            'headers' => $this->headers,
            'body' => $body,
            'maxResult' => $args['maxResult'],
        ];

        return $this->requestHandler->handleRequest($requestArgs);
    }
}
