<?php

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

class RawResponse implements ResponseInterface
{
    private $format;
    private $content;

    public function __construct(string $format, string $content)
    {
        $this->format = $format;
        $this->content = $content;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function setFormat($format): void
    {
        $this->format = $format;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }
}