<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Adapter;

use Pagerfanta\Adapter\AdapterInterface;

class LinkdataAdapter implements AdapterInterface
{
    private $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function getArray(): array
    {
        return $this->array;
    }

    public function getNbResults(): int
    {
        return \count($this->array);
    }

    public function getSlice($offset, $length)
    {
        return \array_slice($this->array, $offset, $length);
    }
}
