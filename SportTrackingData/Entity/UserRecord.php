<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string    getId()
 * @method void      setId(string $id)
 * @method User      getUser()
 * @method void      setUser(User $user)
 * @method Datatype  getDatatype()
 * @method void      setDatatype(Datatype $datatype)
 * @method Activity  getActivity()
 * @method void      setActivity(Activity $activity)
 * @method Sport     getSport()
 * @method void      setSport(Sport $sport)
 * @method string    getType()
 * @method void      setType(string $type)
 * @method float     getValue()
 * @method void      setValue(float $value)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
class UserRecord extends ProxyObject
{
    const ALL = 'all';
    const DISTANCE200M = 'distance.200m';
    const DISTANCE400M = 'distance.400m';
    const DISTANCE804M = 'distance.804m';
    const DISTANCE1000M = 'distance.1000m';
    const DISTANCE1609M = 'distance.1609m';
    const DISTANCE3218M = 'distance.3218m';
    const DISTANCE5000M = 'distance.5000m';
    const DISTANCE10000M = 'distance.10000m';
    const DISTANCE21097M = 'distance.21097m';
    const DISTANCE42195M = 'distance.42195m';
    const DISTANCE80000M = 'distance.80000m';
    const DISTANCE100000M = 'distance.100000m';
    const SEARCHED_DISTANCES = [200, 400, 804, 1000, 1609, 3218, 5000, 10000, 21097, 42195, 80000, 100000];

    /**
     * @var string
     * @Groups({"user_record_norm"})
     */
    public $id;

    /**
     * @var User
     * @Groups({"user_record_norm"})
     */
    public $user;

    /**
     * @var Datatype
     * @Groups({"user_record_norm"})
     */
    public $datatype;

    /**
     * @var Activity
     * @Groups({"user_record_norm"})
     */
    public $activity;

    /**
     * @var Sport
     * @Groups({"user_record_norm"})
     */
    public $sport;

    /**
     * @var \DateTime
     * @Groups({"user_record_norm"})
     */
    public $date;

    /**
     * @var string
     * @Groups({"user_record_norm"})
     */
    public $type = 'all';

    /**
     * @var float
     * @Groups({"user_record_norm"})
     */
    public $value;

    /**
     * @var \DateTime
     * @Groups({"user_record_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"user_record_norm"})
     */
    public $updatedAt;
}
