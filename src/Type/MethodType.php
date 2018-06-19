<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Type;

final class MethodType
{
    public const POST = 'post';
    public const PUT = 'put';
    public const GET = 'get';
    public const DELETE = 'delete';

    /** @var array */
    protected static $methods = [
        self::POST => 'post',
        self::PUT => 'put',
        self::GET => 'get',
        self::DELETE => 'delete',
    ];
}
