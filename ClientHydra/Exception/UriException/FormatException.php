<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Exception\UriException;

use Throwable;

class FormatException extends UriException
{
    public function __construct($message = '', Throwable $previous = null)
    {
        $message = \sprintf('Error while validating URI\'s format : %s', $message);

        parent::__construct($message, 0, $previous);
    }
}
