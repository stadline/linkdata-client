<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string         getId()
 * @method void           setId(string $id)
 * @method array          getTranslatedNames()
 * @method void           setTranslatedNames(array $translatedNames)
 * @method Datatype       getTargetDatatype()
 * @method void           setTargetDatatype(Datatype $targetDatatype)
 * @method null|array     getTranslatedBeforeMessage()
 * @method void           setTranslatedBeforeMessage(?array $translatedBeforeMessage)
 * @method null|array     getTranslatedCurrentMessage()
 * @method void           setTranslatedCurrentMessage(?array $translatedCurrentMessage)
 * @method null|array     getTranslatedAfterMessage()
 * @method void           setTranslatedAfterMessage(?array $translatedAfterMessage)
 * @method null|\DateTime getPublishDate()
 * @method void           setPublishDate(?\DateTime $publishDate)
 * @method null|\DateTime getStartedAt()
 * @method void           setStartedAt(?\DateTime $startedAt)
 * @method null|\DateTime getEndedAt()
 * @method void           setEndedAt(?\DateTime $endedAt)
 * @method null|int       getTarget()
 * @method void           setTarget(?int $target)
 * @method int            getResult()
 * @method void           setResult(int $result)
 * @method null|string    getImageUrl()
 * @method void           setImageUrl(?string $imageUrl)
 * @method bool           isActive()
 * @method void           setActive(bool $active)
 * @method \DateTime      getCreatedAt()
 * @method void           setCreatedAt(\DateTime $createdAt)
 * @method \DateTime      getUpdatedAt()
 * @method void           setUpdatedAt(\DateTime $updatedAt)
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
     * @var ?array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $translatedBeforeMessage;

    /**
     * @var ?array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $translatedCurrentMessage;

    /**
     * @var ?array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $translatedAfterMessage;

    /**
     * @var ?\DateTime
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $publishDate;

    /**
     * @var ?\DateTime
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $startedAt;

    /**
     * @var ?\DateTime
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $endedAt;

    /**
     * @var ?int
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $target;

    /**
     * @var int
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $result = 0;

    /**
     * @var ?string
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

    public function hasNameByLocale(string $locale): ?bool
    {
        return isset($this->getTranslatedNames()[$locale]) && !empty($this->getTranslatedNames()[$locale]);
    }

    public function getNameByLocale(string $locale): ?string
    {
        return $this->hasNameByLocale($locale) ? $this->getTranslatedNames()[$locale] : null;
    }

    public function hasBeforeMessageByLocale(string $locale): ?bool
    {
        return isset($this->getTranslatedBeforeMessage()[$locale]) && !empty($this->getTranslatedBeforeMessage()[$locale]);
    }

    public function getBeforeMessageByLocale(string $locale): ?string
    {
        return $this->hasBeforeMessageByLocale($locale) ? $this->getTranslatedBeforeMessage()[$locale] : null;
    }

    public function hasCurrentMessageByLocale(string $locale): ?bool
    {
        return isset($this->getTranslatedCurrentMessage()[$locale]) && !empty($this->getTranslatedCurrentMessage()[$locale]);
    }

    public function getCurrentMessageByLocale(string $locale): ?string
    {
        return $this->hasCurrentMessageByLocale($locale) ? $this->getTranslatedCurrentMessage()[$locale] : null;
    }
    
    public function hasAfterMessageByLocale(string $locale): ?bool
    {
        return isset($this->getTranslatedAfterMessage()[$locale]) && !empty($this->getTranslatedAfterMessage()[$locale]);
    }

    public function getAfterMessageByLocale(string $locale): ?string
    {
        return $this->hasAfterMessageByLocale($locale) ? $this->getTranslatedAfterMessage()[$locale] : null;
    }

    /**
     * Returns challenge state (BEFORE / CURRENT / AFTER).
     *
     * @throws \Exception
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
     * @throws \Exception
     *
     * @return \DateTime
     */
    public function getStartedAtAsDateTimeObject()
    {
        $startedAt = new \DateTime($this->getStartedAt());

        return \DateTime::createFromFormat('Y-m-d H:i:s', $startedAt);
    }

    /**
     * @throws \Exception
     *
     * @return \DateTime
     */
    public function getEndedAtAsDateTimeObject()
    {
        $endedAt = new \DateTime($this->getEndedAt());

        return \DateTime::createFromFormat('Y-m-d H:i:s', $endedAt);
    }

    /**
     * @throws \Exception
     *
     * @return bool
     */
    public function isOver()
    {
        return self::STATE_AFTER === $this->getState();
    }

    /**
     * @throws \Exception
     *
     * @return bool
     */
    public function isInProgress()
    {
        return self::STATE_CURRENT === $this->getState();
    }

    /**
     * @throws \Exception
     *
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
