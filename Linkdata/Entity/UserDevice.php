<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Tests\Model;

/**
 * @method string       getId()
 * @method void         setId(string $id)
 * @method string       getSerial()
 * @method void         setSerial(string $serial)
 * @method null|DeviceModel getModel()
 * @method void         setModel(null|DeviceModel $model)
 * @method Firmware     getFirmware()
 * @method void         setFirmware(Firmware $firmware)
 * @method User         getUser()
 * @method void         setUserUser (User $user)
 * @method int          getOwnership()
 * @method void         setOwnership(int $ownership)
 * @method string       getLastConnectedAt()
 * @method void         setLastConnectedAt(string $lastConnectedAt)
 * @method string       getCreatedAt()
 * @method void         setCreatedAt(string $createdAt)
 * @method string       getUpdatedAt()
 * @method void         setUpdatedAt(string $updatedAt)
 */
class UserDevice extends ProxyObject
{
    /**
     * @var string
     * @Groups({"user_device_norm"})
     */
    public $id;

    /**
     * @var string
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $serial;

    /**
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $model;

    /**
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $firmware;

    /**
     * @var User
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $user;

    /**
     * @var int
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $ownership;

    /**
     * @var string
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    public $lastConnectedAt;

    /**
     * @var string
     * @Groups({"user_device_norm"})
     */
    public $createdAt;

    /**
     * @var string
     * @Groups({"user_device_norm"})
     */
    public $updatedAt;

    public function getAssociatedUser(): ?User
    {
        return $this->getUser();
    }
}
