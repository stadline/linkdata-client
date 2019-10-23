<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\ClientHydra\Adapter;

class RawResponse implements ResponseInterface
{
    private $format;
    private $content;
    private $status;

    public function __construct(int $status, string $format, string $content)
    {
        $this->format = $format;
        $this->content = $content;
        $this->status = $status;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
