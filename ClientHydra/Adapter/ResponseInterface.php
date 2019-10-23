<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\ClientHydra\Adapter;

interface ResponseInterface
{
    public function getStatus(): int;

    public function getContent();
}
