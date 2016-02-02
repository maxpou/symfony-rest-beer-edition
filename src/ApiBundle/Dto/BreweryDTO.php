<?php

namespace ApiBundle\Dto;

use Hateoas\Configuration\Annotation as Hateoas;
use Maxpou\BeerBundle\Model\BreweryInterface;

use ApiBundle\Dto\BeerDTO;

/**
 * BreweryDTO
 * No business logic here
 * @Hateoas\Relation("self", href = @Hateoas\Route("api_get_brewerie", parameters = {"id" = "expr(object.getId())"}))
 */
class BreweryDTO
{
    private $id;

    private $name;

    private $description;

    private $beers;

    public function __construct(BreweryInterface $brewery)
    {
        $this->id          = $brewery->getId();
        $this->name        = $brewery->getName();
        $this->description = $brewery->getDescription();

        $this->beers = array_map(function ($beerEntity) {
            return new BeerDTO($beerEntity);
        }, $brewery->getBeers()->toArray());
    }

    /**
     * @return UUID object id
     */
    public function getId()
    {
        return $this->id;
    }
}
