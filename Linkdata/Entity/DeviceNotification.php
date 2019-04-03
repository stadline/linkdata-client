<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string         getId()
 * @method void           setId(string $id)
 * @method int            getType()
 * @method void           setType(int $type)
 * @method string         getPath()
 * @method void           setPath(string $path)
 * @method null|\DateTime getClosedAt()
 * @method void           setClosedAt(?\DateTime $closedAt)
 * @method UserDevice     getUserDevice()
 * @method void           setUserDevice(UserDevice $userDevice)
 * @method \DateTime      getCreatedAt()
 * @method void           setCreatedAt(\DateTime $createdAt)
 * @method \DateTime      getUpdatedAt()
 * @method void           setUpdatedAt(\DateTime $updatedAt)
 */
class DeviceNotification extends ProxyObject
{
    /**
     * @var string
     * @Groups({"device_notification_norm"})
     */
    public $id;

    /**
     * @var int
     * @Groups({"device_notification_norm", "device_notification_denorm"})
     */
    public $type;

    /**
     * @var string
     * @Groups({"device_notification_norm", "device_notification_denorm"})
     */
    public $path;

    /**
     * @var ?\DateTime
     * @Groups({"device_notification_norm"})
     */
    public $closedAt;

    /**
     * @var UserDevice
     * @Groups({"device_notification_norm", "device_notification_denorm"})
     */
    public $userDevice;

    /**
     * @var \DateTime
     * @Groups({"device_notification_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"device_notification_norm"})
     */
    public $updatedAt;
}
