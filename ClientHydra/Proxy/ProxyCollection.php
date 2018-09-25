<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

use Stadline\LinkdataClient\ClientHydra\Adapter\JsonResponse;
use Stadline\LinkdataClient\ClientHydra\Utils\IriConverter;

class ProxyCollection implements \Iterator, \ArrayAccess, \Countable
{
    private const INITAL_CURSOR_POSITION = 0;

    /** @var ProxyObject[] */
    private $objects;
    /** @var ProxyManager */
    private $proxyManager;

    /* Internal metadata */
    private $currentIteratorPosition;
    private $nextPageUri;

    public function __construct(
        ProxyManager $proxyManager,
        IriConverter $iriConverter,
        string $classname,
        array $filters = []
    ) {
        $this->proxyManager = $proxyManager;
        $this->objects = [];
        $this->currentIteratorPosition = self::INITAL_CURSOR_POSITION;
        $this->nextPageUri = $iriConverter->generateCollectionUri($classname, $filters);
    }

    public function hasNext(): bool
    {
        return $this->offsetExists($this->currentIteratorPosition + 1);
    }

    private function isHydratationFinished(): bool
    {
        return null === $this->nextPageUri;
    }

    public function next(): void
    {
        ++$this->currentIteratorPosition;
    }

    private function isHydratationRequired(?int $neededPosition = null): bool
    {
        if (null === $neededPosition) {
            $neededPosition = $this->currentIteratorPosition;
        }

        return !$this->isHydratationFinished() && $neededPosition > \count($this->objects);
    }

    private function hydrate(?int $neededPosition = null): int
    {
        if (null === $neededPosition) {
            $neededPosition = $this->currentIteratorPosition;
        }

        $totalHydratedElements = 0;
        $lastHydratedElementsNumber = null;
        while ($this->isHydratationRequired($neededPosition) && ($lastHydratedElementsNumber > 0 || null === $lastHydratedElementsNumber)) {
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
                $object = $this->proxyManager->getProxyFromIri($member['@id']);
                $object->_hydrate($member);
                $this->objects[] = $object;
            }

            // Update metadata
            if (null !== ($data['hydra:view']['hydra:next'] ?? null)) {
                $this->nextPageUri = $data['hydra:view']['hydra:next'];
            } else {
                $this->nextPageUri = null;
            }

            $lastHydratedElementsNumber = \count($data['hydra:member']);
            $totalHydratedElements += $lastHydratedElementsNumber;
        }

        return $totalHydratedElements;
    }

    public function current()
    {
        return $this->offsetGet($this->currentIteratorPosition);
    }

    public function key()
    {
        return $this->currentIteratorPosition;
    }

    public function valid()
    {
        if ($this->isHydratationRequired()) {
            $this->hydrate();
        }

        return isset($this->objects[$this->currentIteratorPosition]);
    }

    public function rewind(): void
    {
        $this->currentIteratorPosition = self::INITAL_CURSOR_POSITION;
    }

    public function offsetExists($offset): bool
    {
        if (!\is_int($offset)) {
            throw new \RuntimeException('Cannot use non-int offset in ProxyCollection');
        }

        if ($this->isHydratationRequired($offset)) {
            $this->hydrate($offset);
        }

        return isset($this->objects[$offset]);
    }

    public function offsetGet($offset)
    {
        if (!\is_int($offset)) {
            throw new \RuntimeException('Cannot use non int offset in ProxyCollection');
        }

        if ($this->isHydratationRequired($offset)) {
            $this->hydrate($offset);
        }

        return $this->objects[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        throw new \RuntimeException('Cannot set object in a ProxyCollection');
    }

    public function offsetUnset($offset): void
    {
        throw new \RuntimeException('Cannot unset object in a ProxyCollection');
    }

    public function isEmpty(): bool
    {
        return 0 === \count($this->objects) && $this->isHydratationFinished();
    }

    public function count()
    {
        while (!$this->isHydratationFinished()) {
            $this->hydrate();
        }

        return \count($this->objects);
    }
}
