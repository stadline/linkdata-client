<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Exception;

use Throwable;

class SerializationException extends SerializerException
{
    public function __construct($message = '', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
