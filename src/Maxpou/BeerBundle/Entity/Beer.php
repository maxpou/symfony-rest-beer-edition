<?php

namespace Maxpou\BeerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Maxpou\BeerBundle\Model\BeerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Beer
 *
 * @ORM\Table(name="beer")
 * @ORM\Entity(repositoryClass="Maxpou\BeerBundle\Repository\BeerRepository")
 * @Hateoas\Relation(
 *   "self",
 *   href = @Hateoas\Route("api_get_brewery_beer",
 *     parameters = {"breweryId" = "expr(object.getBreweryId())", "beerId" = "expr(object.getId())"
 *   })
 * )
 * @ExclusionPolicy("none")
 */
class Beer implements BeerInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="alcohol", type="float")
     * @Assert\GreaterThan(
     *     value = 5,
     *     message= "Please, provide real beer ;-) ({{ compared_value }}° minimum)"
     * )
     * @Assert\NotNull()
     */
    private $alcohol;

    /**
     * Brewery
     *
     * @var \Maxpou\BeerBundle\Entity\Brewery
     *
     * @ORM\ManyToOne(targetEntity="Brewery", inversedBy="beers", cascade={"remove"})
     * @ORM\JoinColumn(name="brewery_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull()
     * @Exclude
     */
    private $brewery;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Beer
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
     *
     * @return Beer
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
     * Set alcohol
     *
     * @param float $alcohol
     *
     * @return Beer
     */
    public function setAlcohol($alcohol)
    {
        $this->alcohol = $alcohol;

        return $this;
    }

    /**
     * Get alcohol
     *
     * @return float
     */
    public function getAlcohol()
    {
        return $this->alcohol;
    }

    /**
     * Set brewery
     *
     * @param \Maxpou\BeerBundle\Entity\Brewery $brewery
     *
     * @return Beer
     */
    public function setBrewery(\Maxpou\BeerBundle\Entity\Brewery $brewery = null)
    {
        $this->brewery = $brewery;

        return $this;
    }

    /**
     * Get brewery
     *
     * @return \Maxpou\BeerBundle\Entity\Brewery
     */
    public function getBrewery()
    {
        return $this->brewery;
    }

    /**
     * Get brewery
     *
     * @return \Maxpou\BeerBundle\Entity\Brewery
     */
    public function getBreweryId()
    {
        return $this->brewery->getId();
    }
}
