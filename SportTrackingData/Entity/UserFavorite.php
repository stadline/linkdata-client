<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

class UserFavorite
{
    /**
     * @var User
     * @Groups({"user_favorite_norm", "user_favorite_denorm"})
     */
    public $user;

    /**
     * @var string
     * @Groups({"user_favorite_norm", "user_favorite_denorm"})
     */
    public $type;

    /**
     * @var ?string
     * @Groups({"user_favorite_norm", "user_favorite_denorm"})
     */
    public $provider;

    /**
     * @var string
     * @Groups({"user_favorite_norm", "user_favorite_denorm"})
     */
    public $value;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(?string $provider): void
    {
        $this->provider = $provider;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
