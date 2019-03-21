<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string          getId()
 * @method void            setId(string $id)
 * @method string          getModelId()
 * @method void            setModelId(string $modelId)
 * @method ArrayCollection getUserSessions()
 * @method void            setUserSessions(ArrayCollection $userSessions)
 * @method User            getUser()
 * @method void            setUser(User $user)
 * @method bool            isCurrent()
 * @method void            setCurrent(bool $current)
 * @method ?\DateTime      getEndedAt()
 * @method void            setEndedAt(?\DateTime $endedAt)
 * @method \DateTime       getCreatedAt()
 * @method void            setCreatedAt(\DateTime $createdAt)
 * @method \DateTime       getUpdatedAt()
 * @method void            setUpdatedAt(\DateTime $updatedAt)
 */
class UserProgram extends ProxyObject
{
    /**
     * @var string
     * @Groups({"user_program_norm"})
     */
    public $id;

    /**
     * @var string
     * @Groups({"user_program_norm", "user_program_denorm"})
     */
    public $modelId;

    /**
     * @var User
     * @Groups({"user_program_norm", "user_program_denorm"})
     */
    public $user;

    /**
     * @var ?bool
     * @Groups({"user_program_norm", "user_program_denorm"})
     */
    public $current;

    /**
     * @var ?\DateTime
     * @Groups({"user_program_norm", "user_program_denorm"})
     */
    public $endedAt;

    /**
     * @var \DateTime
     * @Groups({"user_program_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"user_program_norm"})
     */
    public $updatedAt;
}
