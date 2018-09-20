<?php

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

class JsonResponse implements ResponseInterface
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = json_decode($content, true);
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
        return \in_array($this->getType(), ['Hydra:Collection', 'Hydra:PartialCollection']);
    }

    public function getType(): ?string
    {
        return $this->content['@type'] ?? null;
    }
}