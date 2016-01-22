<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Maxpou\BeerBundle\Entity\Brewery;
use Maxpou\BeerBundle\Entity\Beer;

class LoadBeersData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $brewery = new Brewery();
        $brewery->setName('Bosteels brewery');
        $brewery->setDescription('bosteels brewery');
        $manager->persist($brewery);

        $beer = new Beer();
        $beer->setName('Kwak');
        $beer->setDescription('lorem...');
        $beer->setAlcohol('8.4');
        $beer->setBrewery($brewery);
        $manager->persist($beer);

        $beer = new Beer();
        $beer->setName('Tripel Karmeliet');
        $beer->setDescription('lorem...');
        $beer->setAlcohol('8.4');
        $beer->setBrewery($brewery);
        $manager->persist($beer);

        $brewery = new Brewery();
        $brewery->setName('Affligem Brewery');
        $brewery->setDescription('bosteels brewery');
        $manager->persist($brewery);

        $beer = new Beer();
        $beer->setName('Affligem Blond');
        $beer->setDescription('lorem...');
        $beer->setAlcohol('6.8');
        $beer->setBrewery($brewery);
        $manager->persist($beer);

        $beer = new Beer();
        $beer->setName('Affligem Dubbel');
        $beer->setDescription('lorem...');
        $beer->setAlcohol('6.8');
        $beer->setBrewery($brewery);
        $manager->persist($beer);

        $beer = new Beer();
        $beer->setName('Affligem Tripel');
        $beer->setDescription('lorem...');
        $beer->setAlcohol('8.5');
        $beer->setBrewery($brewery);
        $manager->persist($beer);

        $manager->flush();
    }
}
