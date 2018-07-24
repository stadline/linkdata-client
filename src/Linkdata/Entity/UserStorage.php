<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Entity;

use Stadline\LinkdataClient\src\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class UserStorage extends ProxyObject
{
    /**
     * @var string
     * @Groups({"user_storage_norm"})
     */
    protected $id;

    /**
     * @var User
     * @Groups({"user_storage_norm"})
     */
    protected $user;

    /**
     * @var string
     * @Groups({"user_storage_norm"})
     */
    protected $value;

    /**
     * @var StorageKey
     * @Groups({"user_storage_norm"})
     */
    protected $storageKey;

    /**
     * @var string
     * @Groups({"user_storage_norm"})
     */
    private $createdAt;

    /**
     * @var string
     * @Groups({"user_storage_norm"})
     */
    private $updatedAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->hydrate($this->user);
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getStorageKey(): StorageKey
    {
        return $this->hydrate($this->storageKey);
    }

    public function setStorageKey($storageKey): void
    {
        $this->storageKey = $storageKey;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
