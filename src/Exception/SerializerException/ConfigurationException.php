<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Exception\SerializerException;

use Throwable;

class ConfigurationException extends SerializerException
{
    public function __construct($message = '', Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
