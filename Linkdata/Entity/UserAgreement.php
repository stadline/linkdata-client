<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use DateTime;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method int      getId()
 * @method void     setId(int $id)
 * @method User     getUser()
 * @method void     setUser(User $user)
 * @method string   getServiceKey()
 * @method void     setServiceKey(string $serviceKey)
 * @method string   getState()
 * @method void     setState(string $state)
 * @method DateTime getDateAccept()
 * @method void     setDateAccept(DateTime $dateAccept)
 * @method DateTime getDateRepudiation()
 * @method void     setDateRepudiation(DateTime $dateRepudiation)
 * @method string   getFilename()
 * @method void     setFilename(string $filename)
 * @method DateTime getCreatedAt()
 * @method void     setCreatedAt(DateTime $createdAt)
 * @method DateTime getUpdatedAt()
 * @method void     setUpdatedAt(DateTime $updatedAt)
 */
class UserAgreement extends ProxyObject
{
    /**
     * @var int
     *
     * @Groups({"user_agreement_norm", "user.migration"})
     */
    public $id;

    /**
     * @var User
     *
     * @Groups({"user_agreement_norm", "user_agreement_post"})
     */
    public $user;

    /**
     * @var string
     *
     * @Groups({"user_agreement_norm", "user_agreement_post", "user.migration"})
     */
    public $serviceKey;

    /**
     * @var string
     *
     * @Groups({"user_agreement_norm", "user_agreement_denorm", "user.migration"})
     */
    public $state;

    /**
     * @var DateTime
     *
     * @Groups({"user_agreement_norm", "user.migration"})
     */
    public $dateAccept;

    /**
     * @var DateTime
     *
     * @Groups({"user_agreement_norm", "user.migration"})
     */
    public $dateRepudiation;

    /**
     * @var string
     *
     * @Groups({"user_agreement_norm", "user_agreement_post", "user.migration"})
     */
    public $filename;

    /**
     * @var DateTime
     *
     * @Groups({"user_agreement_norm", "user.migration"})
     */
    public $createdAt;

    /**
     * @var DateTime
     *
     * @Groups({"user_agreement_norm", "user.migration"})
     */
    public $updatedAt;
}
