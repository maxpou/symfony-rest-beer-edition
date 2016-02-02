<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use ApiBundle\Dto\BreweryDTO;

/**
 * Branche controller.
 *
 */
class BreweryController extends FOSRestController
{
    /**
     * Get all Breweries entities
     *
     * @ApiDoc(
     *  statusCodes={
     *      200="Returned when successful"
     * })
     * @QueryParam(name="offset", requirements="\d+", nullable=true,
     *     description="Offset from which to start listing breweries.")
     * @QueryParam(name="limit", requirements="\d+", nullable=true,
     *     description="How many breweries to return.")
     */
    public function getBreweriesAction(ParamFetcher $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit  = $paramFetcher->get('limit');

        $em        = $this->getDoctrine()->getManager();
        $breweries = $em  ->getRepository('MaxpouBeerBundle:Brewery')
                          ->findBy([], ['name' => 'ASC'], $limit, $offset);

        $breweryCollection = array_map(function ($aBrewery) {
            return $breweryCollection[] = new BreweryDTO($aBrewery);
        }, $breweries);

        return $breweryCollection;
    }

    /**
      * Get a Brewery entity
      *
      * @ApiDoc(
      *  statusCodes={
      *      200="Returned when successful",
      *      400="Returned when parameter is wrong",
      *      404="Returned when not found"
      * })
      *
      */
    public function getBrewerieAction($id)
    {
        $brewery = $this->getDoctrine()->getManager()
                        ->getRepository('MaxpouBeerBundle:Brewery')
                        ->find($id);

        if (!$brewery) {
            throw new HttpException(404, 'Unable to find this Brewery entity');
        }

        return new BreweryDTO($brewery);
    }
}
