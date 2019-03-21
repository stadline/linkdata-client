<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string    getId()
 * @method void      setId(string $id)
 * @method User      getUser()
 * @method void      setUser(User $user)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
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
     * @var \DateTime
     * @Groups({"share_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"share_norm"})
     */
    public $updatedAt;
}
