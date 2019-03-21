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
 * @method Activity  getActivity()
 * @method void      setActivity(Activity $activity)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
class ShareActivity extends ProxyObject
{
    /**
     * @var string
     *
     * @Groups({"share_activity_norm", "user.migration"})
     */
    public $id;

    /**
     * @var User
     *
     * @Groups({"share_activity_norm", "share_activity_denorm", "user.migration"})
     */
    public $user;

    /**
     * @var Activity
     *
     * @Groups({"share_activity_norm", "share_activity_denorm", "user.migration"})
     */
    public $activity;

    /**
     * @var \DateTime
     *
     * @Groups({"activity_norm", "user.migration"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     *
     * @Groups({"activity_norm", "user.migration"})
     */
    public $updatedAt;
}
