<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Client;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Adapter\AdapterInterface;
use Stadline\LinkdataClient\ClientHydra\Adapter\ResponseInterface;
use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\ClientHydra\Exception\FormatException;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyManager;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;

abstract class AbstractHydraClient implements HydraClientInterface
{
    private $proxyManager;
    private $adapter;

    public function __construct(ProxyManager $proxyManager, AdapterInterface $adapter)
    {
        $this->proxyManager = $proxyManager;
        $this->adapter = $adapter;
    }

    protected function call(string $method, array $args)
    {
        if (1 !== \preg_match('/^(?<method>[a-z]+)(?<className>[A-Za-z]+)$/', $method, $matches)) {
            throw new FormatException(\sprintf('The method %s is not recognized.', $method));
        }

        $method = \strtolower($matches['method']);
        $className = Inflector::singularize($matches['className']);

        switch ($method) {
            case 'get':
                return $this->callGet($className, $args);
            case 'put':
                return $this->callPut($args);
            case 'delete':
                $this->callDelete($className, $args);

                return null;
            case 'post':
                return $this->callPost($args);
        }

        throw new \RuntimeException('Cannot determine method to call');
    }

    /**
     * @throws ClientHydraException
     */
    public function __call(string $method, array $args)
    {
        return $this->call($method, $args);
    }

    private function callGet(string $classname, array $args)
    {
        // collection case
        if (!isset($args[0]) || \is_array($args[0])) {
            return $this->proxyManager->getCollection($classname, $args[0]['filters'] ?? []);
        }

        // item (string | int) case
        if (\is_int($args[0]) || \is_string($args[0])) {
            return $this->proxyManager->getObject($classname, $args[0]);
        }

        throw new \RuntimeException('Unknown error during call get');
    }

    private function callPut(array $args)
    {
        if (!$args[0] instanceof ProxyObject) {
            throw new \RuntimeException('Put require a proxy object in parameter');
        }

        return $this->proxyManager->putObject($args[0]);
    }

    private function callDelete($className, array $args): void
    {
        if (!\is_string($args[0]) || !\is_int($args[0])) {
            throw new \RuntimeException('Delete require a string or an int in parameter');
        }

        $this->proxyManager->deleteObject($className, $args[0]);
    }

    private function callPost(array $args)
    {
        if (!$args[0] instanceof ProxyObject) {
            throw new \RuntimeException('Post require a proxy object in parameter');
        }

        return $this->proxyManager->postObject($args[0]);
    }

    protected function customCall(string $method, string $uri, array $headers = [], string $body = null): ResponseInterface
    {
        return $this->adapter->makeRequest(
            $method,
            $uri,
            $headers,
            $body
        );
    }

    public function getProxyManager(): ProxyManager
    {
        return $this->proxyManager;
    }

    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }
}
