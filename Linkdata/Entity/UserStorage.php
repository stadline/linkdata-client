<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class UserStorage extends ProxyObject
{
    /**
     * @var string
     * @Groups({"userstorage_norm", "userstorage_denorm})
     */
    protected $id;

    /**
     * @var User
     * @Groups({"userstorage_norm", "userstorage_denorm})
     */
    protected $user;

    /**
     * @var string
     * @Groups({"userstorage_norm", "userstorage_denorm})
     */
    protected $value;

    /**
     * @var StorageKey
     * @Groups({"userstorage_norm", "userstorage_denorm})
     */
    protected $storageKey;

    /**
     * @var string
     * @Groups({"userstorage_norm", "userstorage_denorm})
     */
    private $createdAt;

    /**
     * @var string
     * @Groups({"userstorage_norm", "userstorage_denorm})
     */
    private $updatedAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getUser()
    {
        $this->user->_hydrate();

        return $this->user;
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
        if (is_string($user)) {
            $user = $this->getProxyManager()->getProxyFromIri($user);
        }

        $this->user = $user;
    }

    public function getStorageKey()
    {
        $this->storageKey->_hydrate();

        return $this->storageKey;
    }

    public function setStorageKey($storageKey): void
    {
        if (is_string($storageKey)) {
            $storageKey = $this->getProxyManager()->getProxyFromIri($storageKey);
        }

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
