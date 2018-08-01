<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\ClientHydra\Exception\PaginatorException;

use Stadline\LinkdataClient\src\ClientHydra\Exception\ClientHydraException;
use Throwable;

class PaginatorException extends ClientHydraException
{
    public function __construct($message = '', Throwable $previous = null)
    {
        $message = \sprintf('An error occurred during paginate results. Error : %s.', $message);

        parent::__construct($message, 0, $previous);
    }
}