<?php


namespace SportTrackingDataSdk\SportTrackingData\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method User              getUser()
 * @method void              setUser(User $user)
 * @method string            getType()
 * @method void              setType(string $type)
 * @method ?string           getProvider()
 * @method void              setProvider(?string $provider)
 * @method string            getValue()
 * @method void              setValue(string $value)
 */
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
}
