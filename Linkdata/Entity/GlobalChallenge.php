<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string    getId()
 * @method void      setId(string $id)
 * @method array     getTranslatedNames()
 * @method void      setTranslatedNames(array $translatedNames)
 * @method Datatype  getTargetDatatype()
 * @method void      setTargetDatatype(Datatype $targetDatatype)
 * @method array     getTranslatedBeforeMessage()
 * @method void      setTranslatedBeforeMessage(array $translatedBeforeMessage)
 * @method array     getTranslatedCurrentMessage()
 * @method void      setTranslatedCurrentMessage(array $translatedCurrentMessage)
 * @method array     getTranslatedAfterMessage()
 * @method void      setTranslatedAfterMessage(array $translatedAfterMessage)
 * @method \DateTime getPublishDate()
 * @method void      setPublishDate(\DateTime $publishDate)
 * @method \DateTime getStartedAt()
 * @method void      setStartedAt(\DateTime $startedAt)
 * @method \DateTime getEndedAt()
 * @method void      setEndedAt(\DateTime $endedAt)
 * @method int       getTarget()
 * @method void      setTarget(int $target)
 * @method int       getResult()
 * @method void      setResult(int $result)
 * @method string    getImageUrl()
 * @method void      setImageUrl(string $imageUrl)
 * @method bool      isActive()
 * @method void      setActive(bool $active)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
class GlobalChallenge extends ProxyObject
{
    const STATE_BEFORE = -1;
    const STATE_CURRENT = 0;
    const STATE_AFTER = 1;

    /**
     * @var string
     * @Groups({"global_challenge_norm"})
     */
    public $id;

    /**
     * @var array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $translatedNames;

    /**
     * @var Datatype
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $targetDatatype;

    /**
     * @var array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $translatedBeforeMessage;

    /**
     * @var array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $translatedCurrentMessage;

    /**
     * @var array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $translatedAfterMessage;

    /**
     * @var \DateTime
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $publishDate;

    /**
     * @var \DateTime
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $startedAt;

    /**
     * @var \DateTime
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $endedAt;

    /**
     * @var int
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $target;

    /**
     * @var int
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $result = 0;

    /**
     * @var string
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $imageUrl;

    /**
     * @var bool
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $active = true;

    /**
     * @var \DateTime
     * @Groups({"global_challenge_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"global_challenge_norm"})
     */
    public $updatedAt;

    public function hasNameByLocale(string $locale): bool
    {
        return isset($this->translatedNames[$locale]) && !empty($this->translatedNames[$locale]);
    }

    public function getNameByLocale(string $locale): ?string
    {
        return $this->hasNameByLocale($locale) ? $this->translatedNames[$locale] : null;
    }

    /**
     * Returns challenge state (BEFORE / CURRENT / AFTER).
     *
     * @return int
     */
    public function getState()
    {
        $now = new \DateTime();
        $startedAt = $this->getStartedAtAsDateTimeObject();
        $endedAt = $this->getEndedAtAsDateTimeObject();

        if ($startedAt > $now) {
            return self::STATE_BEFORE;
        }
        if ($this->endedAt && $now >= $endedAt) {
            return self::STATE_AFTER;
        }

        return self::STATE_CURRENT;
    }

    /**
     * @return \DateTime
     */
    public function getStartedAtAsDateTimeObject()
    {
        $startedAt = new \DateTime($this->startedAt);

        return \DateTime::createFromFormat('Y-m-d H:i:s', $startedAt);
    }

    /**
     * @return \DateTime
     */
    public function getEndedAtAsDateTimeObject()
    {
        $endedAt = new \DateTime($this->endedAt);

        return \DateTime::createFromFormat('Y-m-d H:i:s', $endedAt);
    }

    /**
     * @return bool
     */
    public function isOver()
    {
        return self::STATE_AFTER === $this->getState();
    }

    /**
     * @return bool
     */
    public function isInProgress()
    {
        return self::STATE_CURRENT === $this->getState();
    }

    /**
     * @return bool
     */
    public function isNotStarted()
    {
        return self::STATE_BEFORE === $this->getState();
    }

    /**
     * @return bool
     */
    public function isDistance()
    {
        return Datatype::DISTANCE === $this->getTargetDatatype()->getId();
    }
}
