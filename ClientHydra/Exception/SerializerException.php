<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Exception;

use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
use Throwable;

class SerializerException extends ClientHydraException
{
    public function __construct($message = '', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
