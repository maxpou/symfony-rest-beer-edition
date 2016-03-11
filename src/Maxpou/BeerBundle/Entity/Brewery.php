<?php

namespace Maxpou\BeerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\AccessType;
use Hateoas\Configuration\Annotation as Hateoas;

use Maxpou\BeerBundle\Model\BreweryInterface;
use Maxpou\BeerBundle\Entity\Beer;

/**
 * Brewery
 *
 * @ORM\Table(name="brewery")
 * @ORM\Entity(repositoryClass="Maxpou\BeerBundle\Repository\BreweryRepository")
 * @Hateoas\Relation(
 *   "self",
 *   href = @Hateoas\Route("api_get_brewery",
 *   parameters = {"breweryId" = "expr(object.getId())"}
 * ))
 * @Hateoas\Relation("beers", href = @Hateoas\Route(
 *   "api_get_brewery_beers",
 *   parameters = {"breweryId" = "expr(object.getId())"},
 *  ),
 *  exclusion = @Hateoas\Exclusion(groups = {"details"})
 * )
 * @UniqueEntity("name")
 */
class Brewery implements BreweryInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @Groups({"list", "details"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"list", "details"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Groups({"details"})
     */
    private $description;

    /**
     * Beer
     *
     * @var \Maxpou\BeerBundle\Entity\Beer
     *
     * @ORM\OneToMany(targetEntity="Beer", mappedBy="brewery", cascade={"remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Exclude
     */
    private $beers;

    public function __construct($id = null)
    {
        $this->id = $id;
        $this->beers = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return UUID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Brewery
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Brewery
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add beer
     *
     * @param Beer $beer
     * @return Brewery
     */
    public function addBeer(Beer $beer)
    {
        $this->beers[] = $beer;

        return $this;
    }

    /**
     * Remove beer
     *
     * @param Beer $beer
     */
    public function removeBeer(Beer $beer)
    {
        $this->beers->removeElement($beer);
    }

    /**
     * Get beers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBeers()
    {
        return $this->beers;
    }
}
