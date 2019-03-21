<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use DateTime;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;

/**
 * @method string      getUsername()
 * @method void        setUsername(string $username)
 * @method             getPassword()
 * @method void        setPassword( $password)
 * @method null|string getPlainPassword()
 * @method void        setPlainPassword(null|string $plainPassword)
 * @method DateTime    getCreatedAt()
 * @method void        setCreatedAt(DateTime $createdAt)
 * @method DateTime    getUpdatedAt()
 * @method void        setUpdatedAt(DateTime $updatedAt)
 * @method string      getRole()
 * @method void        setRole(string $role)
 */
class Admin extends ProxyObject
{
    /**
     * @var string
     */
    public $username;

    public $password;

    /**
     * @var null|string
     */
    public $plainPassword;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $updatedAt;

    /**
     * @var string
     */
    public $role;
}
