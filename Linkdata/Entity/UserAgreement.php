<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method int        getId()
 * @method void       setId(int $id)
 * @method User       getUser()
 * @method void       setUser(User $user)
 * @method string     getServiceKey()
 * @method void       setServiceKey(string $serviceKey)
 * @method string     getState()
 * @method void       setState(string $state)
 * @method null|\DateTime getDateAccept()
 * @method void       setDateAccept(?\DateTime $dateAccept)
 * @method null|\DateTime getDateRepudiation()
 * @method void       setDateRepudiation(?\DateTime $dateRepudiation)
 * @method string     getFilename()
 * @method void       setFilename(string $filename)
 * @method \DateTime  getCreatedAt()
 * @method void       setCreatedAt(\DateTime $createdAt)
 * @method \DateTime  getUpdatedAt()
 * @method void       setUpdatedAt(\DateTime $updatedAt)
 */
class UserAgreement extends ProxyObject
{
    /**
     * @var int
     * @Groups({"user_agreement_norm"})
     */
    public $id;

    /**
     * @var User
     * @Groups({"user_agreement_norm", "user_agreement_post"})
     */
    public $user;

    /**
     * @var string
     * @Groups({"user_agreement_norm", "user_agreement_post"})
     */
    public $serviceKey;

    /**
     * @var string
     * @Groups({"user_agreement_norm", "user_agreement_denorm"})
     */
    public $state;

    /**
     * @var ?\DateTime
     * @Groups({"user_agreement_norm"})
     */
    public $dateAccept;

    /**
     * @var ?\DateTime
     * @Groups({"user_agreement_norm"})
     */
    public $dateRepudiation;

    /**
     * @var string
     * @Groups({"user_agreement_norm", "user_agreement_post"})
     */
    public $filename;

    /**
     * @var \DateTime
     * @Groups({"user_agreement_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"user_agreement_norm"})
     */
    public $updatedAt;
}
