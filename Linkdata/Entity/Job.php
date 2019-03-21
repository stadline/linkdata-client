<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string     getId()
 * @method void       setId(string $id)
 * @method string     getState()
 * @method void       setState(string $state)
 * @method string     getType()
 * @method void       setType(string $type)
 * @method array      getParams()
 * @method void       setParams(array $params)
 * @method DateTime   getStartedAt()
 * @method void       setStartedAt(DateTime $startedAt)
 * @method DateTime   getCreatedAt()
 * @method void       setCreatedAt(DateTime $createdAt)
 * @method DateTime   getUpdatedAt()
 * @method void       setUpdatedAt(DateTime $updatedAt)
 * @method User       getOwner()
 * @method void       setOwner(User $owner)
 * @method Activity   getActivity()
 * @method void       setActivity(Activity $activity)
 * @method array      getTags()
 * @method void       setTags(array $tags)
 * @method string     getUniqueKey()
 * @method void       setUniqueKey(string $uniqueKey)
 * @method Job        getParent()
 * @method void       setParent(Job $parent)
 * @method Collection getChildren()
 * @method void       setChildren(Collection $children)
 * @method DateTime   getDueDate()
 * @method void       setDueDate(DateTime $dueDate)
 * @method int        getNbTimesLaunched()
 * @method void       setNbTimesLaunched(int $nbTimesLaunched)
 * @method Collection getFollowingJobs()
 * @method void       setFollowingJobs(Collection $followingJobs)
 * @method Job        getWaitingJob()
 * @method void       setWaitingJob(Job $waitingJob)
 */
class Job extends ProxyObject
{
    /**
     * @var string
     *
     * @Groups({"job_norm"})
     */
    public $id;

    /**
     * @var string
     *
     * @Groups({"job_norm"})
     */
    public $state;

    /**
     * @var string
     *
     * @Groups({"job_norm"})
     */
    public $type;

    /**
     * @var array
     *
     * @Groups({"job_norm"})
     */
    public $params;

    /**
     * @var DateTime
     *
     * @Groups({"job_norm"})
     */
    public $startedAt;

    /**
     * @var DateTime
     *
     * @Groups({"job_norm"})
     */
    public $createdAt;

    /**
     * @var DateTime
     *
     * @Groups({"job_norm"})
     */
    public $updatedAt;

    /**
     * @var User
     *
     * @Groups({"job_norm"})
     */
    public $owner;

    /**
     * @var Activity
     *
     * @Groups({"job_norm"})
     */
    public $activity;

    /**
     * @var array
     *
     * @Groups({"job_norm"})
     */
    public $tags;

    /**
     * @var string
     *
     * @Groups({"job_norm"})
     */
    public $uniqueKey;

    /**
     * @var Job
     *
     * @Groups({"job_norm"})
     */
    public $parent;

    /**
     * @var Collection
     */
    public $children;

    /**
     * @var DateTime
     *
     * @Groups({"job_norm"})
     */
    public $dueDate;

    /**
     * @var int
     */
    public $nbTimesLaunched;

    /**
     * @var Collection
     */
    public $followingJobs;

    /**
     * @var Job
     *
     * @Groups({"job_norm"})
     */
    public $waitingJob;
}
