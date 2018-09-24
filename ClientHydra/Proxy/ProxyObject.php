<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

use Stadline\LinkdataClient\ClientHydra\Adapter\JsonResponse;
use Stadline\LinkdataClient\ClientHydra\Utils\HydraParser;
use Stadline\LinkdataClient\ClientHydra\Utils\IriConverter;
use Symfony\Component\Serializer\SerializerInterface;

class ProxyObject
{
    /** @var ProxyManager */
    private $proxyManager;
    /** @var SerializerInterface */
    private $serializer;
    /** @var IriConverter */
    private $iriConverter;

    /* internal metadata */
    private $hydrated;
    private $iri;
    private $className;
    private $id;

    public function __construct(
        IriConverter $iriConverter,
        SerializerInterface $serializer,
        ProxyManager $proxyManager,
        string $className,
        $id,
        ?array $data
    )
    {
        $this->proxyManager = $proxyManager;
        $this->serializer = $serializer;
        $this->iriConverter = $iriConverter;

        $this->className = $className;
        $this->id = $id;
        $this->iri = $this->iriConverter->getIriFromClassNameAndId($this->className, $this->id);
        $this->hydrated = false;

        if (null !== $data) {
            $this->_hydrate($data);
        }
    }

    /**
     * Hydrate an object with an IRI given.
     * If hydrate is set to false, it returns the IRI given.
     */
    public function _hydrate(?array $data = null): void
    {
// WHY ?
//        if (!$this->hydrated) {
//            return $iri;
//        }

        // already hydrated : ignore
        if (true === $this->hydrated) {
            return;
        }

        // if data is empty = get data from api
        if (null === $data) {
            $requestResponse = $this->proxyManager->getAdapter()->makeRequest(
                'GET',
                $this->iri
            );

            if (!$requestResponse instanceof JsonResponse) {
                throw new \RuntimeException('Cannot hydrate object with non json response');
            }

            $data = $requestResponse->getContent();
        }

        $this->_refresh($data);
    }

    public function _refresh(array $data)
    {
        $this->serializer->deserialize(json_encode($data), $this->className, 'json', [
            'object_to_populate' => $this,
            'groups' => [HydraParser::getDenormContext($data)]
        ]);
        $this->hydrated = true;
    }

    public function _isHydrated(): bool
    {
        return $this->hydrated;
    }
}