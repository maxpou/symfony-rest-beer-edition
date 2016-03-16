<?php
namespace Maxpou\BeerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Maxpou\BeerBundle\Entity\Beer;
use Maxpou\BeerBundle\Entity\Brewery;

class LoadBeersData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //Bosteels
        $brewery = new Brewery();
        $brewery->setName('Bosteels brewery');
        $brewery->setDescription('bosteels brewery');
        $manager->persist($brewery);
        $beer = new Beer();
        $beer->setName('Kwak');
        $beer->setAlcohol('8.4');
        $beer->setBrewery($brewery);
        $brewery->setDescription('<3');
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Tripel Karmeliet');
        $beer->setAlcohol('8.4');
        $beer->setBrewery($brewery);
        $brewery->setDescription('Miam');
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Deus');
        $beer->setAlcohol('10');
        $beer->setBrewery($brewery);
        $manager->persist($beer);

        $brewery = new Brewery();
        $brewery->setName('Duvel Moortgat');
        $brewery->setDescription('Since 1871');
        $manager->persist($brewery);
        $beer = new Beer();
        $beer->setName('Duvel');
        $beer->setAlcohol('8.5');
        $beer->setBrewery($brewery);
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Duvel tripel hop');
        $beer->setAlcohol('9.5');
        $beer->setBrewery($brewery);
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('La Chouffe');
        $beer->setAlcohol('8');
        $beer->setBrewery($brewery);
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Maredsous 6° blond');
        $beer->setAlcohol('6');
        $beer->setBrewery($brewery);
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Maredsous 8° brown');
        $beer->setAlcohol('8');
        $beer->setBrewery($brewery);
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Maredsous 10° tripel');
        $beer->setAlcohol('8');
        $beer->setBrewery($brewery);
        $brewery->setDescription('The hangover');
        $manager->persist($beer);

        //Affligem
        $brewery = new Brewery();
        $brewery->setName('Affligem Brewery');
        $brewery->setDescription('The abbey of Affligem was founded around 1074');
        $manager->persist($brewery);
        $beer = new Beer();
        $beer->setName('Affligem Blond');
        $beer->setAlcohol('6.8');
        $beer->setBrewery($brewery);
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Affligem Dubbel');
        $beer->setAlcohol('6.8');
        $beer->setBrewery($brewery);
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Affligem Tripel');
        $beer->setAlcohol('8.5');
        $beer->setBrewery($brewery);
        $manager->persist($beer);

        //Rochefort
        $brewery = new Brewery();
        $brewery->setName('Rochefort');
        $manager->persist($brewery);
        $beer = new Beer();
        $beer->setName('Rochefort 6');
        $beer->setAlcohol('7.5');
        $beer->setBrewery($brewery);
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Rochefort 8');
        $beer->setAlcohol('9.2');
        $beer->setBrewery($brewery);
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Rochefort 10');
        $beer->setAlcohol('11.3');
        $beer->setBrewery($brewery);
        $manager->persist($beer);

        //Chimay
        $brewery = new Brewery();
        $brewery->setName('Chimay');
        $manager->persist($brewery);
        $beer = new Beer();
        $beer->setName('Chimay Rouge');
        $beer->setAlcohol('7');
        $beer->setBrewery($brewery);
        $manager->persist($beer);
        $beer = new Beer();
        $beer->setName('Chimay Tripel');
        $beer->setAlcohol('10.5');
        $beer->setBrewery($brewery);
        $manager->persist($beer);

        $manager->flush();
    }
}
