Symfony Rest Beer Edition (Work in progress)
============================================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/665c060e-aa8a-458a-b74c-44c5725c7155/big.png)](https://insight.sensiolabs.com/projects/665c060e-aa8a-458a-b74c-44c5725c7155)  
[![Build Status](https://travis-ci.org/maxpou/symfony-rest-beer-edition.svg?branch=master)](https://travis-ci.org/maxpou/symfony-rest-beer-edition)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maxpou/symfony-rest-beer-edition/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/maxpou/symfony-rest-beer-edition/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/maxpou/symfony-rest-beer-edition/badge.svg?branch=master)](https://coveralls.io/github/maxpou/symfony-rest-beer-edition?branch=master)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square)](https://php.net/)


Welcome to the Symfony Rest Beer Edition!  

Features in this application:

* Specific HTTP Status Codes (204, 206, 400, 404...), HTTP Verbs (GET/POST/PUT/DELETE/OPTIONS)
* Routes with subresources, collection filters...
* Fully swagger documentation (visit /api/doc)
* Symfony's Form component support
* Routes pluralization (beer -> beers & brewery -> breweries).  
*See class ApiBundle\Util\Inflector\BreweryInflector.*
* Serialization exclusion strategies
* HATEOAS with exclusions policies - use [Hypertext Application Language](http://stateless.co/hal_specification.html) (HAL)
* Support JSON/XML format

## Installation

1. Update parameters.yml (create a new secret key)
2. Execute this commands
```
composer install
php app/console doctrine:database:create  
php app/console doctrine:schema:create  
php app/console doctrine:fixtures:load -n
```
3. Check configuration by executing `php app/check.php`
4. Test `phpunit -c app`

## What's inside?

* All Symfony default bundles (FrameworkBundle, DoctrineBundle, TwigBundle, MonologBundle...)
* [JMSSerializerBundle](https://github.com/schmittjoh/JMSSerializerBundle) - Easily serialize, and deserialize data of any complexity (supports XML, JSON, YAML)
* [FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle) provides several tools to assist in building REST applications
* [BazingaHateoasBundle](https://github.com/willdurand/BazingaHateoasBundle) provide HATEOAS
* [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle) provide a nice documentation for API (inspired by Swagger UI project)
* [NelmioCorsBundle](https://github.com/nelmio/NelmioCorsBundle) adds CORS headers support in your Symfony2 application
* [DoctrineFixturesBundle](DoctrineFixturesBundle) provide breweries and beers (see Maxpou\BeerBundle\DataFixtures\ORM\LoadBeersData.php)

And in /src :

* **ApiBundle** : contain API controllers
* **MaxpouBeerBundle** : contains entities, forms, fixtures and back office controllers
* **AppBundle** : Back office controllers... not very important!

*Back-office views use [Bootstrap](http://getbootstrap.com) (CDN Host)*

## Focuses

**Entities:**  
We have only 2 entities: Brewery and Beer (Many-To-One relationship).

**Code First approach:**  
I use Code First approach (by opposition to Database/Model First). It's mean that I start by writing classes not model/SQL DDL orders. Otherwise it's hard to maintain (I know, doctrine is reverse engineering compliant).

**UUID:**  
Prefer UUID instead of auto increment because, it's make harder to discover existing resources (for malignant users). Also, it's might not be unique in distributed systems.


## TODO

**REST misconfiguration:**  
- [ ] POST /whatever-collection... -> must return HTTP header: `Location: http://app.com/breweries/newidcreated`
- [ ] GET /whatever on array objects, Only put URI
- [ ] GET /whatever-collection -> must return HTTP code 206 (Partial content) and add links into Link HTTP headers (e.g. fist, prev, next and last page)

**Enhancements:**  
- [ ] Make controllers **more thins!** (use ParamConverter, avoid doctrine research in controllers)
- [ ] Test with [DHC](https://dhc.restlet.com)  
- [ ] Implement PATCH HTTP method
- [ ] Exclusion strategy: allow HTTP header Prefer/Vary (Request) and Vary/Preference-Applied (Response). Because clients don't need the same information
- [ ] Allow sort collection
- [ ] Add a /serve API to implement HTTP Rate limitation.  
HTTP Headers:
  * X-RateLimit-Limit: Total number of beer allow to drink ;)
  * X-RateLimit-Remaining: Beer left
  * X-RateLimit-Reset: remaining window before rate limit resets (UTC epoch seconds)
