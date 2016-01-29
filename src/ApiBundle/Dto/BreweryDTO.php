<?php

namespace ApiBundle\Dto;

use Hateoas\Configuration\Annotation as Hateoas;
use Maxpou\BeerBundle\Model\BreweryInterface;

/**
 * BreweryDTO
 * No business logic here
 */
class BreweryDTO
{
    private $id;

    private $name;

    private $description;

    //private $beers;

    public function __construct(BreweryInterface $brewery)
    {
        $this->id          = $brewery->getId();
        $this->name        = $brewery->getName();
        $this->description = $brewery->getDescription();
        //$this->beers       = $brewery->getDescription();
    }
}
