<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

use Stadline\LinkdataClient\ClientHydra\Adapter\JsonResponse;
use Stadline\LinkdataClient\ClientHydra\Utils\HydraParser;
use Stadline\LinkdataClient\ClientHydra\Utils\IriConverter;
use Symfony\Component\Serializer\SerializerInterface;

abstract class ProxyObject
{
    /** @var ProxyManager */
    private $proxyManager;
    /** @var SerializerInterface */
    private $serializer;

    /* internal metadata */
    private $_hydrated;
    private $_iri;
    private $_className;

    /**
     * Hydrate an object with an IRI given.
     * If hydrate is set to false, it returns the IRI given.
     */
    public function _hydrate(?array $data = null): void
    {
        // already hydrated : ignore
        if (true === $this->_hydrated) {
            return;
        }

        // if data is empty = get data from api
        if (null === $data) {
            $requestResponse = $this->proxyManager->getAdapter()->makeRequest(
                'GET',
                $this->_iri
            );

            if (!$requestResponse instanceof JsonResponse) {
                throw new \RuntimeException('Cannot hydrate object with non json response');
            }

            $data = $requestResponse->getContent();
        }

        $this->_refresh($data);
    }

    public function _refresh(array $data): void
    {
        $this->serializer->deserialize(\json_encode($data), $this->_className, 'json', [
            'object_to_populate' => $this,
            'groups' => [HydraParser::getDenormContext($data)],
        ]);
        $this->_hydrated = true;
    }

    public function _isHydrated(): bool
    {
        return $this->_hydrated;
    }

    protected function getProxyManager(): ProxyManager
    {
        return $this->proxyManager;
    }

    public function _init(
        IriConverter $iriConverter,
        SerializerInterface $serializer,
        ProxyManager $proxyManager,
        string $className,
        $id,
        ?array $data = null
    ): void {
        $this->proxyManager = $proxyManager;
        $this->serializer = $serializer;
        $this->_className = $className;
        $reflectionClass = new \ReflectionClass($this);

        if ($reflectionClass->hasMethod('setId')) {
            $reflectionMethod = $reflectionClass->getMethod('setId');
            $reflectionParameter = $reflectionMethod->getParameters()[0];

            switch ($reflectionParameter->getType()) {
                case 'string':
                    $this->setId((string) $id);
                    break;
                case 'float':
                    $this->setId((float) $id);
                    break;
                case 'int':
                    $this->setId((int) $id);
                    break;
                default:
                    throw new \RuntimeException('This parameter type is not supported in setId method');
            }
        }

        $this->_iri = $iriConverter->getIriFromClassNameAndId($this->_className, $id);
        $this->_hydrated = false;

        if (null !== $data) {
            $this->_hydrate($data);
        }
    }
}
