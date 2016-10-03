<?php

namespace ApiBundle\Tests\Controller;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BeerApiControllerTest extends WebTestCase
{
    public static function setUpBeforeClass()
    {
        $client = static::createClient();
        $em = $client->getContainer()
                     ->get('doctrine')
                     ->getManager();

        $loader = new Loader();
        $loader->loadFromDirectory('src/Maxpou/BeerBundle/DataFixtures');

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
        $this->assertEquals($response->headers->get('allow'), 'OPTIONS, GET, POST, DELETE');
    }

    /**
     * Test 404, 400 (x2), 201.
     *
     * @depends testFindBoostels
     */
    public function testPost($bosteelsId)
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/breweries/ThisBreweryDoesNotExist/beers',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{
                "name":"Fake Beer",
                "alcohol":"8"
            }'
        );

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
        $this->assertRegExp('/Unable to find this Brewery entity/', $response->getContent());

        $client->request(
            'POST',
            '/api/breweries/'.$bosteelsId.'/beers',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{
                "name":"Fake Beer",
                "alcohol":"1"
            }'
        );

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
        $this->assertRegExp('/provide real beer/', $response->getContent());

        $client->request(
            'POST',
            '/api/breweries/'.$bosteelsId.'/beers',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{
                "alcohol":"10"
            }'
        );

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
        $this->assertRegExp('/This value should not be blank./', $response->getContent());

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
        $this->assertArrayHasKey('id', $data);
        $generatedBeerId = $data['id'];

        return $generatedBeerId;
    }

    /**
     * @depends testFindBoostels
     * @depends testPost
     */
    public function testPut($bosteelsId, $generatedBeerId)
    {
        $client = static::createClient();

        $client->request(
            'PUT',
            '/api/breweries/'.$bosteelsId.'/beers/ThisBeerDoesNotExist',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{
                "name":"Christmas beer",
                "alcohol":"1"
            }'
        );

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());

        $client->request(
            'PUT',
            '/api/breweries/'.$bosteelsId.'/beers/'.$generatedBeerId,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{
                "name":"Christmas beer",
                "alcohol":"1"
            }'
        );

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());

        $client->request(
            'PUT',
            '/api/breweries/'.$bosteelsId.'/beers/'.$generatedBeerId,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{
                "name":"Christmas beer",
                "description":"I think this beer is a fake and never exist",
                "alcohol":"99"
            }'
        );

        $response = $client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testFindBoostels
     * @depends testPost
     */
    public function testGet($bosteelsId, $generatedBeerId)
    {
        $client = static::createClient();

        //fail (404)
        $client->request('GET', '/api/breweries/'.$bosteelsId.'/beers/ThisBeerDoesNotExist');
        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertContains('Unable to find this Beer entity', $response->getContent(), $response->getContent());

        $client->request('GET', '/api/breweries/ThisBreweryDoesNotExist/beers/'.$generatedBeerId);
        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertContains('Unable to find this Brewery entity', $response->getContent(), $response->getContent());

        //Success
        $client->request('GET', '/api/breweries/'.$bosteelsId.'/beers/'.$generatedBeerId);
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Christmas beer', $data['name'], $response->getContent());
        $this->assertContains('his beer is a fake', $data['description'], $response->getContent());
        $this->assertArrayHasKey('_links', $data);
    }

    /**
     * @depends testFindBoostels
     * @depends testPost
     */
    public function testDelete($bosteelsId, $generatedBeerId)
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/breweries/'.$bosteelsId.'/beers/'.$generatedBeerId);

        $response = $client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());

        //Ensure that the beer has been droped
        $client->request('GET', '/api/breweries/'.$bosteelsId.'/beers/'.$generatedBeerId);

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());

        //..but the brewery is still here!
        $client->request('GET', '/api/breweries/'.$bosteelsId.'/beers');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testFindBoostels
     */
    public function testDeleteCollection($bosteelsId)
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/breweries/ThisBreweryDoesNotExist/beers');

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());

        $client->request('DELETE', '/api/breweries/'.$bosteelsId.'/beers');

        $response = $client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());

        //Ensure
        $client->request('GET', '/api/breweries/'.$bosteelsId.'/beers');
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertEquals([], $data);
    }
}
