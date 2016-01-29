<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
     * @return [type] [description]
     *
     */
    public function getBreweriesAction()
    {
        $em        = $this->getDoctrine()->getManager();
        $breweries = $em  ->getRepository('MaxpouBeerBundle:Brewery')
                        ->findBy([], ['name' => 'ASC']);

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
      *      404="Returned when not found",
      * })
      * @return [type] [description]
      *
      * @TODO: change ubly name(Brewerie)
      */
    public function getBrewerieAction($id)
    {
    }
}
