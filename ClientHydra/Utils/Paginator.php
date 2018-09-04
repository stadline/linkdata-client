<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Exception\LessThan1MaxPerPageException;
use Pagerfanta\Exception\NotIntegerMaxPerPageException;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;
use Stadline\LinkdataClient\ClientHydra\Exception\PaginatorException\PaginatorException;

class Paginator extends Pagerfanta
{
    public function __construct(AdapterInterface $adapter)
    {
        parent::__construct($adapter);
    }

    /**
     * @throws PaginatorException
     */
    public function setMaxResultPerPage(int $maxResult): void
    {
        try {
            $this->setMaxPerPage($maxResult);
        } catch (NotIntegerMaxPerPageException $e) {
            throw new PaginatorException(\sprintf('%s is not a valid number.', $maxResult), $e);
        } catch (LessThan1MaxPerPageException $e) {
            throw new PaginatorException(\sprintf('%s need to be greater than 0.', $maxResult), $e);
        }
    }

    /**
     * @throws PaginatorException
     */
    public function setPageCurrent(int $currentPage): void
    {
        try {
            $this->setCurrentPage($currentPage);
        } catch (NotIntegerMaxPerPageException $e) {
            throw new PaginatorException(\sprintf('%s is not a valid number.', $currentPage), $e);
        } catch (LessThan1MaxPerPageException $e) {
            throw new PaginatorException(\sprintf('%s need to be greater than 0.', $currentPage), $e);
        } catch (OutOfRangeCurrentPageException $e) {
            throw new PaginatorException(\sprintf('the page %s is out of range.', $currentPage), $e);
        }
    }

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
