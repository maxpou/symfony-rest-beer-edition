<?php

namespace Maxpou\BeerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Maxpou\BeerBundle\Entity\Beer;

class LoadBeersData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        //Bosteels
        $beer = new Beer();
        $beer->setName('Kwak');
        $beer->setAlcohol('8.4');
        $beer->setBrewery($this->getReference('brewery-bosteels'));
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Tripel Karmeliet');
        $beer->setAlcohol('8.4');
        $beer->setBrewery($this->getReference('brewery-bosteels'));
        $beer->setDescription('Miam');
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Deus');
        $beer->setAlcohol('10');
        $beer->setBrewery($this->getReference('brewery-bosteels'));
        $manager->persist($beer);

        //Duvel
        $beer = new Beer();
        $beer->setName('Duvel');
        $beer->setAlcohol('8.5');
        $beer->setBrewery($this->getReference('brewery-duvel'));
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Duvel tripel hop');
        $beer->setAlcohol('9.5');
        $beer->setBrewery($this->getReference('brewery-duvel'));
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('La Chouffe');
        $beer->setAlcohol('8');
        $beer->setBrewery($this->getReference('brewery-duvel'));
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Maredsous 6° blond');
        $beer->setAlcohol('6');
        $beer->setBrewery($this->getReference('brewery-duvel'));
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Maredsous 8° brown');
        $beer->setAlcohol('8');
        $beer->setBrewery($this->getReference('brewery-duvel'));
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Maredsous 10° tripel');
        $beer->setAlcohol('8');
        $beer->setBrewery($this->getReference('brewery-duvel'));
        $beer->setDescription('The hangover');
        $manager->persist($beer);

        //Affligem
        $beer = new Beer();
        $beer->setName('Affligem Blond');
        $beer->setAlcohol('6.8');
        $beer->setBrewery($this->getReference('brewery-affligem'));
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Affligem Dubbel');
        $beer->setAlcohol('6.8');
        $beer->setBrewery($this->getReference('brewery-affligem'));
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Affligem Tripel');
        $beer->setAlcohol('8.5');
        $beer->setBrewery($this->getReference('brewery-affligem'));
        $manager->persist($beer);

        //Rochefort
        $beer = new Beer();
        $beer->setName('Rochefort 6');
        $beer->setAlcohol('7.5');
        $beer->setBrewery($this->getReference('brewery-rochefort'));
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Rochefort 8');
        $beer->setAlcohol('9.2');
        $beer->setBrewery($this->getReference('brewery-rochefort'));
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Rochefort 10');
        $beer->setAlcohol('11.3');
        $beer->setBrewery($this->getReference('brewery-rochefort'));
        $manager->persist($beer);

        //Chimay
        $beer = new Beer();
        $beer->setName('Chimay Rouge');
        $beer->setAlcohol('7');
        $beer->setBrewery($this->getReference('brewery-chimay'));
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Chimay Tripel');
        $beer->setAlcohol('10.5');
        $beer->setBrewery($this->getReference('brewery-chimay'));
        $manager->persist($beer);

        $manager->flush();
    }
}
