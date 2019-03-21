<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

/**
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\UserRouteRepository"
 * )
 * @ApiResource(
 *     attributes={
 *         "normalization_context" = {"groups" = {"user_route_norm"}},
 *         "denormalization_context" = {"groups" = {"user_route_denorm"}}
 *     },
 *     collectionOperations={
 *         "get" = {
 *             "normalization_context" = {"groups" = {"user_route_norm_cget"}}
 *         },
 *         "post",
 *     }
 * )
 * @Userable(fieldName="user")
 */
class UserRoute
{
    public const LOCATIONS_FILE = 'locations.json';

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string", nullable=false, unique=true, length=32)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="\AppBundle\Doctrine\IdGenerator")
     * @Groups({"user_route_norm", "user_route_norm_cget"})
     */
    protected $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userRoutes")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\NotNull
     * @Groups({"user_route_norm", "user_route_norm_cget", "user_route_denorm"})
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Type("string")
     * @Assert\NotNull
     * @Groups({"user_route_norm", "user_route_norm_cget", "user_route_denorm"})
     */
    protected $libelle;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     * @Assert\Range(min=0)
     * @Groups({"user_route_norm", "user_route_norm_cget", "user_route_denorm"})
     */
    protected $distance;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     * @Groups({"user_route_norm", "user_route_norm_cget", "user_route_denorm"})
     */
    protected $ascendant;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     * @Groups({"user_route_norm", "user_route_norm_cget", "user_route_denorm"})
     */
    protected $descendant;

    /**
     * Temp storage for locations.
     *
     * @var array
     *
     * @Groups({"user_route_norm", "user_route_denorm"})
     *
     * @Locations
     */
    private $locations;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Range(
     *     min=-90,
     *     max=90
     * )
     * @Groups({"user_route_norm"})
     */
    private $latitude;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Range(
     *     min=-180,
     *     max=180
     * )
     * @Groups({"user_route_norm"})
     */
    private $longitude;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"user_route_norm"})
     */
    private $elevation;

    /** @var callable */
    private $locationsGetterCallback;

    /**
     * @var bool
     * @ORM\Column(type="boolean", options={"default" = false})
     * @Groups({"user_route_norm"})
     */
    private $correctedElevation = false;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"user_route_norm", "user_route_norm_cget"})
     */
    private $createdAt;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"user_route_norm", "user_route_norm_cget"})
     */
    private $updatedAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(?int $distance): void
    {
        $this->distance = $distance;
    }

    public function getAscendant(): ?int
    {
        return $this->ascendant;
    }

    public function setAscendant(?int $ascendant): void
    {
        $this->ascendant = $ascendant;
    }

    public function getDescendant(): ?int
    {
        return $this->descendant;
    }

    public function setDescendant(?int $descendant): void
    {
        $this->descendant = $descendant;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getLocations(): ?array
    {
        if (null === $this->locations && null !== $this->locationsGetterCallback) {
            $this->setLocations(($this->locationsGetterCallback)($this));
        }

        return $this->locations;
    }

    public function setLocations(?array $locations): void
    {
        if (empty($locations)) {
            $locations = null;
        }
        $this->locations = $locations;
    }

    public function setLocationsGetterCallback(callable $locationsGetterCallback): void
    {
        $this->locationsGetterCallback = $locationsGetterCallback;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getElevation(): ?float
    {
        return $this->elevation;
    }

    public function setElevation(?float $elevation): void
    {
        $this->elevation = $elevation;
    }

    public function getCorrectedElevation(): bool
    {
        return $this->correctedElevation;
    }

    public function setCorrectedElevation(bool $correctedElevation): void
    {
        $this->correctedElevation = $correctedElevation;
    }

    public function getElevationFlag(): bool
    {
        return $this->getCorrectedElevation();
    }

    public function __toString()
    {
        return $this->id;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
