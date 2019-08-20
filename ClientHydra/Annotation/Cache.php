<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Annotation;

use Doctrine\Common\Annotations\Annotation\Attribute;

/**
 * @Annotation
 * @Target({"CLASS"})
 * @Attributes(
 *     @Attribute("public", type="bool"),
 *     @Attribute("ttl", type="int"),
 *     @Attribute("warmup", type="bool"),
 * )
 */
class Cache
{
    public $public = false;
    public $ttl = 3600;
    public $warmup = false;
}
