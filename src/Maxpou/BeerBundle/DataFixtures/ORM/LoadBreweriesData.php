<?php

namespace Maxpou\BeerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Maxpou\BeerBundle\Entity\Brewery;

class LoadBreweriesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        //Bosteels
        $brewery = new Brewery();
        $brewery->setName('Bosteels brewery');
        $brewery->setDescription('bosteels brewery');
        $this->addReference('brewery-bosteels', $brewery);
        $manager->persist($brewery);

        //Duvel
        $brewery = new Brewery();
        $brewery->setName('Duvel Moortgat');
        $brewery->setDescription('Since 1871');
        $this->addReference('brewery-duvel', $brewery);
        $manager->persist($brewery);

        //Affligem
        $brewery = new Brewery();
        $brewery->setName('Affligem Brewery');
        $brewery->setDescription('The abbey of Affligem was founded around 1074');
        $this->addReference('brewery-affligem', $brewery);
        $manager->persist($brewery);

        //Rochefort
        $brewery = new Brewery();
        $brewery->setName('Rochefort');
        $this->addReference('brewery-rochefort', $brewery);
        $manager->persist($brewery);

        //Chimay
        $brewery = new Brewery();
        $brewery->setName('Chimay');
        $this->addReference('brewery-chimay', $brewery);
        $manager->persist($brewery);

        $manager->flush();
    }
}
