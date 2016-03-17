<?php

namespace Maxpou\BeerBundle\Tests\Controller;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Maxpou\BeerBundle\DataFixtures\ORM\LoadBeersData;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BeerControllerTest extends WebTestCase
{
    public static function setUpBeforeClass()
    {
        $client = static::createClient();
        $em = $client->getContainer()
                     ->get('doctrine')
                     ->getManager();

        $loader = new Loader();
        $loader->addFixture(new LoadBeersData());

        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
    }

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/beer/');
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /admin/beer/"
        );
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'name'        => 'TestBeer',
            'description' => 'TestDescription',
            'alcohol'     => 9.3
            //default Brewery = first one
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(
            0,
            $crawler->filter('td:contains("TestBeer")')->count(),
            'Missing element td:contains("TestBeer")'
        );

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'name'  => 'FooBeer'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(
            0,
            $crawler->filter('[value="FooBeer"]')->count(),
            'Missing element [value="FooBeer"]'
        );

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/FooBeer/', $client->getResponse()->getContent());
    }
}
