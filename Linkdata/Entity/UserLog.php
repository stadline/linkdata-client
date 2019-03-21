<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use DateTime;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;

/**
 * @method string   getId()
 * @method void     setId(string $id)
 * @method string   getUser()
 * @method void     setUser(string $user)
 * @method string   getType()
 * @method void     setType(string $type)
 * @method DateTime getCreatedAt()
 * @method void     setCreatedAt(DateTime $createdAt)
 * @method array    getData()
 * @method void     setData(array $data)
 */
class UserLog extends ProxyObject
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $type;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var array
     */
    public $data;
}
