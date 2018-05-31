<?php

declare(strict_types=1);

namespace Geonaute\LinkdataClient\Client;

interface LinkdataGuzzleClientInterface
{
    public function getElement(string $elementId, array $filters = []);

    public function getElements(array $filters = []): array;
}
