<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method int         getId()
 * @method void        setId(int $id)
 * @method string      getName()
 * @method void        setName(string $name)
 * @method null|string getValue()
 * @method void        setValue(?string $value)
 * @method UserDevice  getUserDevice()
 * @method void        setUserDevice(UserDevice $userDevice)
 * @method \DateTime   getCreatedAt()
 * @method void        setCreatedAt(\DateTime $createdAt)
 * @method \DateTime   getUpdatedAt()
 * @method void        setUpdatedAt(\DateTime $updatedAt)
 */
class UserDeviceSetting extends ProxyObject
{
    /**
     * @var int
     * @Groups({"user_device_setting_norm"})
     */
    public $id;

    /**
     * @var string
     * @Groups({"user_device_setting_norm", "user_device_setting_denorm"})
     */
    public $name;

    /**
     * @var ?string
     * @Groups({"user_device_setting_norm", "user_device_setting_denorm"})
     */
    public $value;

    /**
     * @var UserDevice
     * @Groups({"user_device_setting_norm", "user_device_setting_denorm"})
     */
    public $userDevice;

    /**
     * @var \DateTime
     * @Groups({"user_device_setting_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"user_device_setting_norm"})
     */
    public $updatedAt;
}
