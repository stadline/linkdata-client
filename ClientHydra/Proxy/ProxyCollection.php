<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

use Stadline\LinkdataClient\ClientHydra\Adapter\JsonResponse;
use Stadline\LinkdataClient\ClientHydra\Client\HydraClientInterface;

class ProxyCollection implements \Iterator, \ArrayAccess, \Countable
{
    private const INITAL_CURSOR_POSITION = 0;

    /** @var ProxyObject[] */
    private $objects;
    private $hydraClient;

    /* Internal metadata */
    private $currentIteratorPosition;
    private $nextPageUri;
    private $cacheEnable = true;
    private $autoHydrateEnable = true;

    public function __construct(
        HydraClientInterface $hydraClient,
        array $initialData,
        bool $cacheEnable = true,
        bool $autoHydrateEnable = true
    ) {
        $this->cacheEnable = $cacheEnable;
        $this->autoHydrateEnable = $autoHydrateEnable;
        $this->hydraClient = $hydraClient;
        $this->objects = [];
        $this->currentIteratorPosition = self::INITAL_CURSOR_POSITION;

        $this->_refresh($initialData);
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

        return !$this->isHydratationFinished() && $neededPosition >= \count($this->objects);
    }

    private function hydrate(?int $neededPosition = null): int
    {
        if (null === $neededPosition) {
            $neededPosition = $this->currentIteratorPosition;
        }

        $totalHydratedElements = 0;
        $lastHydratedElementsNumber = null;
        do {
            $requestResponse = $this->hydraClient->getAdapter()->makeRequest(
                'GET',
                $this->nextPageUri,
                [],
                null,
                $this->cacheEnable
            );

            if (!$requestResponse instanceof JsonResponse) {
                throw new \RuntimeException('Cannot hydrate collection with non json response');
            }

            $lastHydratedElementsNumber = $this->_refresh($requestResponse->getContent());
            $totalHydratedElements += $lastHydratedElementsNumber;
            if (!$this->isHydratationFinished() && $lastHydratedElementsNumber < 1) {
                throw new \RuntimeException(\sprintf('Unknown error : received %d elements only but hydratation not finished', $lastHydratedElementsNumber));
            }
        } while ($this->isHydratationRequired($neededPosition));

        return $totalHydratedElements;
    }

    private function _refresh(array $data): int
    {
        // Set next page uri
        if (null !== ($data['hydra:view']['hydra:next'] ?? null)) {
            $this->nextPageUri = $data['hydra:view']['hydra:next'];
        } else {
            $this->nextPageUri = null;
        }

        // Members
        if (isset($data['hydra:member'])) {
            foreach ($data['hydra:member'] as $member) {
                $object = $this->hydraClient->getProxyFromIri($member['@id']);
                $object->_refresh($member);
                $this->objects[] = $object;
            }

            if (true === $this->autoHydrateEnable && null !== ($data['hydra:view']['hydra:next'] ?? null)) {
                $this->nextPageUri = $data['hydra:view']['hydra:next'];
            } else {
                $this->nextPageUri = null;
            }

            // remove next page if autohydrate disable
            if (false === $this->autoHydrateEnable) {
                $this->nextPageUri = null;
            }
        }

        // return number of added elements
        return \count($data['hydra:member'] ?? []);
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
        return $this->offsetExists($this->currentIteratorPosition);
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
        if (!\is_int($offset)) {
            throw new \RuntimeException('Cannot use non int offset in ProxyCollection');
        }

        if ($this->isHydratationRequired($offset)) {
            $this->hydrate($offset);
        }

        $this->objects[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        if (!\is_int($offset)) {
            throw new \RuntimeException('Cannot use non int offset in ProxyCollection');
        }

        if ($this->offsetExists($offset)) {
            unset($this->objects[$offset]);

            // Re-index array
            $this->objects = \array_values($this->objects);

            // As we removed one element, rollback iterator position to previous
            if ($this->currentIteratorPosition > self::INITAL_CURSOR_POSITION) {
                --$this->currentIteratorPosition;
            }
        }
    }

    public function isEmpty(): bool
    {
        return !$this->offsetExists(0);
    }

    public function count(): int
    {
        while (!$this->isHydratationFinished()) {
            $this->hydrate();
        }

        return \count($this->objects);
    }
}
