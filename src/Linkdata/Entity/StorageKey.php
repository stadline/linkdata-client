<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Entity;

use Stadline\LinkdataClient\src\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

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
    private $createdAt;

    /**
     * @var string
     * @Groups({"storage_key_norm"})
     */
    private $updatedAt;

    /**
     * @var bool
     * @Groups({"storage_key_norm"})
     */
    private $active = true;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
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

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
