<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string    getId()
 * @method void      setId(string $id)
 * @method User      getUser()
 * @method void      setUser(User $user)
 * @method string    getUrl()
 * @method void      setUrl(string $url)
 * @method array     getEvents()
 * @method void      setEvents(array $events)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
class UserWebHook extends ProxyObject
{
    /**
     * @var string
     * @Groups({"user_web_hook_norm"})
     */
    public $id;

    /**
     * @var User
     * @Groups({"user_web_hook_norm", "user_web_hook_denorm"})
     */
    public $user;

    /**
     * @var string
     * @Groups({"user_web_hook_norm", "user_web_hook_denorm"})
     */
    public $url;

    /**
     * @var array
     * @Groups({"user_web_hook_norm", "user_web_hook_denorm"})
     */
    public $events;

    /**
     * @var \DateTime
     * @Groups({"user_web_hook_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"user_web_hook_norm"})
     */
    public $updatedAt;
}
