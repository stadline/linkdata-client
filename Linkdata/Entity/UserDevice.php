<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class UserDevice extends ProxyObject
{
    /**
     * @var string
     * @Groups({"user_device_norm"})
     */
    protected $id;

    /**
     * @var string
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    protected $serial;

    /**
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    protected $model;

    /**
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    protected $firmware;

    /**
     * @var User
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    protected $user;

    /**
     * @var int
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    protected $ownership;

    /**
     * @var string
     * @Groups({"user_device_norm", "user_device_denorm"})
     */
    protected $lastConnectedAt;

    /**
     * @var string
     * @Groups({"user_device_norm"})
     */
    private $createdAt;

    /**
     * @var string
     * @Groups({"user_device_norm"})
     */
    private $updatedAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(?string $serial): void
    {
        $this->serial = $serial;
    }

    public function getModel()
    {
        if (null !== $this->model) {
            $this->model->_hydrate();
        }

        return $this->model;
    }

    public function setModel(?DeviceModel $model): void
    {
        $this->model = $model;
    }

//    public function getFirmware(): ?Firmware
//    {
//        return $this->firmware;
//    }

    public function setFirmware($firmware): void
    {
        $this->firmware = $firmware;
    }

    public function getUser(): ?User
    {
        if (null !== $this->user) {
            $this->user->_hydrate();
        }

        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getOwnership(): ?int
    {
        return $this->ownership;
    }

    public function setOwnership(?int $ownership): void
    {
        $this->ownership = $ownership;
    }

    public function getLastConnectedAt(): ?string
    {
        return $this->lastConnectedAt;
    }

    public function setLastConnectedAt(?string $lastConnectedAt): void
    {
        $this->lastConnectedAt = $lastConnectedAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getAssociatedUser(): ?User
    {
        return $this->getUser();
    }
}
