<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Type;

final class FormatType
{
    public const JSON = 'json';
    public const JSONLD = 'json-ld';
    public const GPX = 'gpx';

    /** @var array */
    public static $authorized_formats = [
        self::JSON => 'json',
        self::JSONLD => 'jsonld',
        self::GPX => 'gpx',
    ];
}
