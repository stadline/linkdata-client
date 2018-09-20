<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Pagerfanta\Pagerfanta;

class Paginator extends Pagerfanta
{
    public static function getAllResults(self $data): array
    {
        $results = [];

        while ($data->hasNextPage()) {
            $results[] = $data->getCurrentPageResults();
            $data->setCurrentPage($data->getNextPage());
        }

        return \array_merge(...$results);
    }
}
