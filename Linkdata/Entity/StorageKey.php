<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method int       getId()
 * @method void      setId(int $id)
 * @method string    getSlug()
 * @method void      setSlug(string $slug)
 * @method null|string   getComment()
 * @method void      setComment(?string $comment)
 * @method bool      isActive()
 * @method void      setActive(bool $active)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
class StorageKey extends ProxyObject
{
    /**
     * @var int
     * @Groups({"storage_key_norm"})
     */
    public $id;

    /**
     * @var string
     * @Groups({"storage_key_norm"})
     */
    public $slug;

    /**
     * @var ?string
     * @Groups({"storage_key_norm"})
     */
    public $comment;

    /**
     * @var bool
     * @Groups({"storage_key_norm"})
     */
    public $active = true;

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
}
