<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string getId()
 * @method void   setId(string $id)
 * @method User   getUser()
 * @method void   setUser(User $user)
 * @method string getCreatedAt()
 * @method void   setCreatedAt(string $createdAt)
 * @method string getUpdatedAt()
 * @method void   setUpdatedAt(string $updatedAt)
 */
class ShareUser extends ProxyObject
{
    /**
     * @var string
     * @Groups({"share_norm"})
     */
    public $id;

    /**
     * @var User
     * @Groups({"share_norm", "share_denorm"})
     */
    public $user;

    /**
     * @var string
     * @Groups({"share_norm"})
     */
    public $createdAt;

    /**
     * @var string
     * @Groups({"share_norm"})
     */
    public $updatedAt;
}
