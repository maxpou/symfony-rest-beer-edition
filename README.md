[![SensioLabsInsight](https://insight.sensiolabs.com/projects/665c060e-aa8a-458a-b74c-44c5725c7155/big.png)](https://insight.sensiolabs.com/projects/665c060e-aa8a-458a-b74c-44c5725c7155)  
[![Build Status](https://travis-ci.org/maxpou/symfony-rest-beer-edition.svg?branch=master)](https://travis-ci.org/maxpou/symfony-rest-beer-edition) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maxpou/symfony-rest-beer-edition/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/maxpou/symfony-rest-beer-edition/?branch=master) [![Coverage Status](https://coveralls.io/repos/github/maxpou/symfony-rest-beer-edition/badge.svg?branch=master)](https://coveralls.io/github/maxpou/symfony-rest-beer-edition?branch=master) ![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square)](https://php.net/)

Symfony Rest Beer Edition (Work in progress)
============================================

Welcome to the Symfony Rest Beer Edition!  


**Objects:**  
We have only 2 entities: Brewery and Beer (Many-To-One relationship).

**Code First approach:**  
I use Code First approach (by opposition to Database/Model First). It's mean that I start by writing classes not model/SQL DDL orders. Otherwise it's hard to maintain (I know, doctrine is reverse engineering compliant).


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
4. Test `phpunit -c app ./src`

## Features

* Full swagger documentation (visit /api/doc)
* Pluralization routes (beer -> beers & brewery -> breweries).  
*See class ApiBundle\Util\Inflector\BreweryInflector.*
* HATEOAS support


## What's inside?

* All Symfony default bundles (FrameworkBundle, DoctrineBundle, TwigBundle, MonologBundle...)
* [JMSSerializerBundle](https://github.com/schmittjoh/JMSSerializerBundle) - Easily serialize, and deserialize data of any complexity (supports XML, JSON, YAML)
* [FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle) provides several tools to assist in building REST applications
* [BazingaHateoasBundle](https://github.com/willdurand/BazingaHateoasBundle) provide HATEOAS
* [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle) provide a nice documentation for API (inspired by Swagger UI project)
* [NelmioCorsBundle](https://github.com/nelmio/NelmioCorsBundle) adds CORS headers support in your Symfony2 application

*Back-office views use [Bootstrap](http://getbootstrap.com) (CDN Host)*

## TODO

- [ ] Complete this README.md
- [ ] **Make controllers thins!** (use ParamConverter)
- [ ] Test with [DHC](https://dhc.restlet.com/)  
- [ ] Implement PATCH HTTP method
- [ ] Remove all todo comments
