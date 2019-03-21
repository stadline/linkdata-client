<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string      getId()
 * @method void        setId(string $id)
 * @method ?string     getSerial()
 * @method void        setSerial(?string $serial)
 * @method DeviceModel getModel()
 * @method void        setModel(DeviceModel $model)
 * @method Firmware    getFirmware()
 * @method void        setFirmware(Firmware $firmware)
 * @method User        getUser()
 * @method void        setUserUser (User $user)
 * @method ?int        getOwnership()
 * @method void        setOwnership(?int $ownership)
 * @method ?\DateTime  getLastConnectedAt()
 * @method void        setLastConnectedAt(?\DateTime $lastConnectedAt)
 * @method \DateTime   getCreatedAt()
 * @method void        setCreatedAt(\DateTime $createdAt)
 * @method \DateTime   getUpdatedAt()
 * @method void        setUpdatedAt(\DateTime $updatedAt)
 */
class UserDevice extends ProxyObject
{
    /**
     * @var string
     * @Groups({"user_device_norm"})
     */
    public $id;

    /**
     * @var ?string
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $serial;

    /**
     * @var DeviceModel
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $model;

    /**
     * @var Firmware
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $firmware;

    /**
     * @var User
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $user;

    /**
     * @var ?int
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $ownership;

    /**
     * @var ?\DateTime
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $lastConnectedAt;

    /**
     * @var \DateTime
     * @Groups({"user_device_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"user_device_norm"})
     */
    public $updatedAt;
}
