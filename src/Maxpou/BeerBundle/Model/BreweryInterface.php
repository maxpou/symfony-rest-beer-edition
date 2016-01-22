<?php

namespace Maxpou\BeerBundle\Model;

use Maxpou\BeerBundle\Entity\Beer;

interface BreweryInterface
{
    public function getId();

    public function setName($name);

    public function getName();

    public function setDescription($description);

    public function getDescription();

    public function addBeer(Beer $beer);

    public function removeBeer(Beer $beer);

    public function getBeers();
}
