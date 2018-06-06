<?php

declare(strict_types=1);

namespace Stadline\src\LinkdataClient\Utils;

use Stadline\src\LinkdataClient\Exception\PaginatorException;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Exception\LessThan1MaxPerPageException;
use Pagerfanta\Exception\NotIntegerMaxPerPageException;
use Pagerfanta\Pagerfanta;

abstract class Paginator extends Serializator
{
    /**
     * @throws PaginatorException
     */
    protected function paginate(array $array, int $maxPerPage = 10): Pagerfanta
    {
        $adapter = new ArrayAdapter($array);
        $paginator = new Pagerfanta($adapter);

        try {
            $paginator->setMaxPerPage($maxPerPage);
        } catch (NotIntegerMaxPerPageException $e) {
            throw new PaginatorException(\sprintf('%s is not a valid number', $maxPerPage));
        } catch (LessThan1MaxPerPageException $e) {
            throw new PaginatorException(\sprintf('%s need to be greater than 0', $maxPerPage));
        }

        return $paginator;
    }
}
