<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Exception;

use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
use Throwable;

class HandlerException extends ClientHydraException
{
    public function __construct($message = '', Throwable $previous = null)
    {
        $message = \sprintf('An error occurred during Handle request. Error : %s.', $message);

        parent::__construct($message, 0, $previous);
    }
}
