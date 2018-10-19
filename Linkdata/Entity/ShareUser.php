<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class ShareUser extends ProxyObject
{
    /**
     * @var string
     * @Groups({"share_norm"})
     */
    private $id;

    /**
     * @var User
     *
     * @Groups({"share_norm", "share_denorm"})
     */
    protected $user;

    /**
     * @var string
     * @Groups({"share_norm"})
     */
    private $createdAt;

    /**
     * @var string
     * @Groups({"share_norm"})
     */
    private $updatedAt;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|User
     */
    public function getUser()
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

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
