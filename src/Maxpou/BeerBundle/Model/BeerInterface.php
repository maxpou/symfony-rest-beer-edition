<?php

namespace Maxpou\BeerBundle\Model;

use Maxpou\BeerBundle\Entity\Brewery;

interface BeerInterface
{
    public function getId();

    public function setName($name);

    public function getName();

    public function setDescription($description);

    public function getDescription();

    public function setAlcohol($alcohol);

    public function getAlcohol();

    public function setBrewery(Brewery $brewery);

    public function getBrewery();
}
