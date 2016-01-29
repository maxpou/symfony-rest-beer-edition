Symfony, REST API and DTO (Work in progress)
============================================

*This code support my talk about Symfony2 and REST.*

## Installation

1. Update parameters.yml
2. Execute this commands
```
composer install
php app/console doctrine:database:create  
php app/console doctrine:schema:create  
php app/console doctrine:fixtures:load
```
3. Execute `php app/check.php`


## Steps by steps

### First step: setting up the application (Maxpou/BeerBundle)

Some informations:

* I have 2 entities: Brewery and Beer (Many-To-One relationship)
* I don't use auto-increment because [it's a terrible idea](https://www.clever-cloud.com/blog/engineering/2015/05/20/why-auto-increment-is-a-terrible-idea/)

This layer use Code First approach (by opposition to Database/Model First). It's mean that I start by writing classes not model/SQL DDL orders. Otherwise it's hard to maintain (I know, doctrine is reverse engineering compliant).

### Second step: REST API ♥ (ApiBundle)

@TODO: setting up the *(real)* REST API  (ApiBundle)

Note that I use [DTO pattern](http://martinfowler.com/eaaCatalog/dataTransferObject.html). **Here**, it doesn't make any sense. But it's pretty cool for large applications.


## Notes

I know, it's ugly. But I'm a back-end developer ;-)

@TODO:  
[ ] Write unit tests  
[ ] Add Travis  
