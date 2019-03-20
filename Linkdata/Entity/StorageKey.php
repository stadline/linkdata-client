<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string getId()
 * @method void   setId(string $id)
 * @method string getSlug()
 * @method void   setSlug(string $slug)
 * @method string getComment()
 * @method void   setComment(string $comment)
 * @method bool   isActive()
 * @method void   setActive(bool $active)
 * @method string getCreatedAt()
 * @method void   setCreatedAt(string $createdAt)
 * @method string getUpdatedAt()
 * @method void   setUpdatedAt(string $updatedAt)
 */
class StorageKey extends ProxyObject
{
    /**
     * @var int
     * @Groups({"storage_key_norm"})
     */
    protected $id;

    /**
     * @var string
     * @Groups({"storage_key_norm"})
     */
    protected $slug;

    /**
     * @var string
     * @Groups({"storage_key_norm"})
     */
    protected $comment;

    /**
     * @var string
     * @Groups({"storage_key_norm"})
     */
    public $createdAt;

    /**
     * @var string
     * @Groups({"storage_key_norm"})
     */
    public $updatedAt;

    /**
     * @var bool
     * @Groups({"storage_key_norm"})
     */
    public $active = true;
}
