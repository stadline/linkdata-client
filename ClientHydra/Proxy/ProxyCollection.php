<?php

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

use Stadline\LinkdataClient\ClientHydra\Adapter\JsonResponse;
use Stadline\LinkdataClient\ClientHydra\Utils\IriConverter;
use Symfony\Component\Serializer\SerializerInterface;

class ProxyCollection implements \Iterator
{
    /** @var ProxyObject[] */
    private $objects;
    /** @var ProxyManager */
    private $proxyManager;
    /** @var SerializerInterface */
    private $serializer;
    /** @var IriConverter */
    private $iriConverter;

    /* Internal metadata */
    private $currentIteratorPosition;
    private $nextPageUri;

    public function __construct(
        ProxyManager $proxyManager,
        SerializerInterface $serializer,
        IriConverter $iriConverter,
        string $classname,
        array $filters = []
    )
    {
        $this->proxyManager = $proxyManager;
        $this->serializer = $serializer;
        $this->iriConverter = $iriConverter;

        $this->objects = [];

        $this->currentIteratorPosition = 0;
        $this->nextPageUri = $iriConverter->generateCollectionUri($classname, $filters);
    }

    public function hasNext(): bool
    {
        if (isset($this->objects[$this->currentIteratorPosition + 1])) {
            return true;
        }

        if (null !== $this->nextPageUri) {
            return (0 < $this->hydrateNextElements());
        }

        return false;
    }

    public function next()
    {
        ++$this->currentIteratorPosition;
        if (isset($this->objects[$this->currentIteratorPosition])) {
            return $this->objects[$this->currentIteratorPosition];
        }

        // currently on last iteration
        if (null !== $this->nextPageUri && 0 === $this->hydrateNextElements()) {
            // reset iterator to last value
            $this->currentIteratorPosition--;
            // no new elements : game over !
            return false;
        }

        return $this->objects[$this->currentIteratorPosition];
    }

    private function hydrateNextElements(): int
    {
        if (null === $this->nextPageUri) {
            throw new \RuntimeException('Unable to hydrate next elements if next page not exist');
        }

        $requestResponse = $this->proxyManager->getAdapter()->makeRequest(
            'GET',
            $this->nextPageUri
        );

        if (!$requestResponse instanceof JsonResponse) {
            throw new \RuntimeException('Cannot hydrate collection with non json response');
        }

        $data = $requestResponse->getContent();

        // Members
        foreach ($data['hydra:member'] as $member) {
            if ($this->proxyManager->hasObject($member['@id'])) {
                $object = $this->proxyManager->getObjectFromIri($member['@id']);
            } else {
                $className = $this->iriConverter->getClassnameFromIri($member['@id']);
                $object = new $className(
                    $this->iriConverter,
                    $this->serializer,
                    $this->proxyManager,
                    $className,
                    $this->iriConverter->getObjectIdFromIri($member['@id']),
                    $member
                );
            }
            $this->objects[] = $object;
        }

        // Update metadata
        if (null !== ($data['hydra:view']['hydra:next'] ?? null)) {
            $this->nextPageUri = $data['hydra:view']['hydra:next'];
        } else {
            $this->nextPageUri = null;
        }

        return \count($data['hydra:member']);
    }

    public function current()
    {
        return $this->objects[$this->currentIteratorPosition] ?? null;
    }

    public function key()
    {
        return $this->currentIteratorPosition;
    }

    public function valid()
    {
        return null !== $this->objects[$this->currentIteratorPosition];
    }

    public function rewind()
    {
        $this->currentIteratorPosition = 0;
    }
}