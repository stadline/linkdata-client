<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use DateTime;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string      getId()
 * @method void        setId(string $id)
 * @method string      getModelId()
 * @method void        setModelId(string $modelId)
 * @method UserProgram getUserProgram()
 * @method void        setUserProgram(UserProgram $userProgram)
 * @method User        getUser()
 * @method void        setUser(User $user)
 * @method int         getPosition()
 * @method void        setPosition(int $position)
 * @method DateTime    getCreatedAt()
 * @method void        setCreatedAt(DateTime $createdAt)
 * @method DateTime    getUpdatedAt()
 * @method void        setUpdatedAt(DateTime $updatedAt)
 * @method string      getType()
 * @method void        setType(string $type)
 */
class UserSession extends ProxyObject
{
    /**
     * @var string
     *
     * @Groups({"user_session_norm", "user.migration"})
     */
    public $id;

    /**
     * @var string
     *
     * @Groups({"user_session_norm", "user_session_denorm", "user.migration"})
     */
    public $modelId;

    /**
     * @var UserProgram
     *
     * @Groups({"user_session_norm", "user_session_denorm", "user.migration"})
     */
    public $userProgram;

    /**
     * @var User
     *
     * @Groups({"user_session_norm", "user_session_denorm"})
     */
    public $user;

    /**
     * @var int
     *
     * @Groups({"user_session_norm", "user_session_denorm", "user.migration"})
     */
    public $position;

    /**
     * @var DateTime
     *
     * @Groups({"user_session_norm", "user.migration"})
     */
    public $createdAt;

    /**
     * @var DateTime
     *
     * @Groups({"user_session_norm", "user.migration"})
     */
    public $updatedAt;

    /**
     * @var string
     *
     * @Groups({"user_session_norm", "user_session_denorm", "user.migration"})
     */
    public $type;
}
