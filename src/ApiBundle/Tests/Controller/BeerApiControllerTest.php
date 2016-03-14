<?php

namespace ApiBundle\Tests\Controller;

use Maxpou\BeerBundle\DataFixtures\ORM\LoadBeersData;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Loader;

class BeerApiControllerTest extends WebTestCase
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

    public function testFindBoostels()
    {
        $client = static::createClient();

        $client->request('GET', '/api/breweries');
        $breweries = json_decode($client->getResponse()->getContent(), true);

        foreach ($breweries as $brewery) {
            if ('Bosteels brewery' === $brewery['name']) {
                $bosteelsId = $brewery['id'];
            }
        }

        return $bosteelsId;
    }

    /**
     * @depends testFindBoostels
     */
    public function testGetCollection($bosteelsId)
    {
        $client = static::createClient();

        $client->request('GET', '/api/breweries/'.$bosteelsId.'/beers');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
        $this->assertArrayHasKey('description', $data[0]);
        $this->assertArrayHasKey('alcohol', $data[0]);
        $this->assertArrayHasKey('_links', $data[0]);
    }

    /**
     * @depends testFindBoostels
     */
    public function testOptions($bosteelsId)
    {
        $client = static::createClient();

        $client->request('OPTIONS', '/api/breweries/'.$bosteelsId.'/beers');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testFindBoostels
     */
    public function testPost($bosteelsId)
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/breweries/'.$bosteelsId.'/beers',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{
                "name":"Christmas beer",
                "alcohol":"9.3"
            }'
        );

        $response = $client->getResponse();
        $this->assertEquals(201, $response->getStatusCode(), $response->getContent());
        $data = json_decode($response->getContent(), true);
        $generatedBeerId = $data['id'];

        return $generatedBeerId;
    }

    /**
     * @depends testFindBoostels
     * @depends testPost
     */
    public function testPut($bosteelsId, $generatedBeerId)
    {
    }

    /**
     * @depends testFindBoostels
     * @depends testPost
     */
    public function testGet($bosteelsId, $generatedBeerId)
    {
    }

    /**
     * @depends testFindBoostels
     * @depends testPost
     */
    public function testDelete($bosteelsId, $generatedBeerId)
    {
    }

    public function testDeleteCollection()
    {
    }
}
