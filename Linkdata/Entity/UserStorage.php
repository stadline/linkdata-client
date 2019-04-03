<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string      getId()
 * @method void        setId(string $id)
 * @method User        getUser()
 * @method void        setUser(User $user)
 * @method null|string getValue()
 * @method void        setValue(?string $value)
 * @method StorageKey  getStorageKey()
 * @method void        setStorageKey(StorageKey $storageKey)
 * @method \DateTime   getCreatedAt()
 * @method void        setCreatedAt(\DateTime $createdAt)
 * @method \DateTime   getUpdatedAt()
 * @method void        setUpdatedAt(\DateTime $updatedAt)
 */
class UserStorage extends ProxyObject
{
    /**
     * @var string
     * @Groups({"userstorage_norm", ""userstorage_denorm})
     */
    public $id;

    /**
     * @var User
     * @Groups({"userstorage_norm", ""userstorage_denorm})
     */
    public $user;

    /**
     * @var ?string
     * @Groups({"userstorage_norm", ""userstorage_denorm})
     */
    public $value;

    /**
     * @var StorageKey
     * @Groups({"userstorage_norm", ""userstorage_denorm})
     */
    public $storageKey;

    /**
     * @var \DateTime
     * @Groups({"userstorage_norm", ""userstorage_denorm})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"userstorage_norm", ""userstorage_denorm})
     */
    public $updatedAt;
}
