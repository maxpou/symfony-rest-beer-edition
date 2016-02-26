<?php

namespace Maxpou\BeerBundle\Model;


interface BreweryInterface
{
    public function getId();

    public function setName($name);

    public function getName();

    public function setDescription($description);

    public function getDescription();
}
