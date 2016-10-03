<?php

namespace ApiBundle\Util\Inflector;

use FOS\RestBundle\Util\Inflector\InflectorInterface;

/**
 * Inflector class.
 */
class BreweryInflector implements InflectorInterface
{
    public function pluralize($word)
    {
        if ('brewery' === $word) {
            $word = 'breweries';
        }

        if ('beer' === $word) {
            $word = 'beers';
        }

        return $word;
    }
}
