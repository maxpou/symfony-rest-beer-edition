<?php

namespace ApiBundle\Dto;

use Hateoas\Configuration\Annotation as Hateoas;
use Maxpou\BeerBundle\Model\BeerInterface;

/**
 * BeerDTO
 * No business logic here
 * @Hateoas\Relation("self", href = @Hateoas\Route("api_get_beer", parameters = {"id" = "expr(object.getId())"}))
 */
class BeerDTO
{
    private $id;

    private $name;

    private $description;

    private $alcohol;

    public function __construct(BeerInterface $beer)
    {
        $this->id          = $beer->getId();
        $this->name        = $beer->getName();
        $this->description = $beer->getDescription();
        $this->alcohol     = $beer->getAlcohol();
    }

    /**
     * @return UUID object id
     */
    public function getId()
    {
        return $this->id;
    }
}
