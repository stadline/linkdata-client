<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string    getId()
 * @method string    getActor()
 * @method string    getObject()
 * @method string    getVerb()
 * @method array     getData()
 * @method \DateTime getDate()
 */
class FeedElement extends ProxyObject
{
    /**
     * @var string
     * @Groups({"feed_element_norm"})
     */
    public $id;

    /**
     * @var ?string
     * @Groups({"feed_element_norm"})
     */
    public $actor;

    /**
     * @var ?string
     * @Groups({"feed_element_norm"})
     */
    public $object;

    /**
     * @var ?string
     * @Groups({"feed_element_norm"})
     */
    public $verb;

    /**
     * @var array
     * @Groups({"feed_element_norm"})
     */
    public $data = [];

    /**
     * @var \DateTime
     * @Groups({"feed_element_norm"})
     */
    public $date;
}
