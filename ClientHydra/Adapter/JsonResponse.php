<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\ClientHydra\Adapter;

class JsonResponse implements ResponseInterface
{
    private $content;
    private $status;

    public function __construct(int $status, string $content)
    {
        $this->status = $status;
        $this->content = \json_decode($content, true);
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function getEntityName(): ?string
    {
        if (!isset($this->content['@context'])) {
            return null;
        }

        return \explode('/', $this->content['@context'])[3] ?? null;
    }

    public function isCollection(): bool
    {
        return \in_array($this->getType(), ['Hydra:Collection', 'Hydra:PartialCollection'], true);
    }

    public function getType(): ?string
    {
        return $this->content['@type'] ?? null;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
