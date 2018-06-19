<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Exception;

use Throwable;

class LinkdataClientFormatException extends LinkdataClientUriException
{
    public function __construct($message = '', $body = null, Throwable $previous = null)
    {
        $message = \sprintf('Error during validate uri\'s format : %s', $message);

        parent::__construct($message, 0, $previous);
    }
}
