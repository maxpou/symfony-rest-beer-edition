Symfony, REST API and DTO (Work in progress)
============================================

*This the code support my talk about Symfony2 and REST.*

# Installation

1. Update parameters.yml
2. Execute this commands
```
composer install
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console doctrine:fixtures:load
```


# Steps by steps

## First step: setting up the application

Some informations:

* I have 2 entities: Brewery and Beer (Many-To-One relationship)
* I don't use auto-increment because [it's a terrible idea](https://www.clever-cloud.com/blog/engineering/2015/05/20/why-auto-increment-is-a-terrible-idea/)

I know, it's ugly ;-)

@TODO:  
[ ] Write unit tests

## Second step: REST API ♥

@TODO: setting up the *(real)* REST API
