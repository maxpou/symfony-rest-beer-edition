<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Hello beer app :)', $crawler->filter('h1')->text());
    }

    public function testBreweryList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/brewery/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Brewery list', $crawler->filter('h1')->text());
    }

    public function testBeerList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/beer/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Beer list', $crawler->filter('h1')->text());
    }

    public function testSwagger()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/doc');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Web API doc', $crawler->filter('h1')->text());
    }
}
