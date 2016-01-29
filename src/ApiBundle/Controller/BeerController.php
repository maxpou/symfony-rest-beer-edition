<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use ApiBundle\Dto\BeerDTO;

/**
 * Beer controller
 */
class BeerController extends FOSRestController
{
    /**
     * Bet all Beers entities
     *
     * @ApiDoc(
     *  statusCodes={
     *      200="Returned when successful"
     * })
     * @return array of BeerDTO
     */
    public function getBeersAction()
    {
        $em    = $this->getDoctrine()->getManager();
        $beers = $em ->getRepository('MaxpouBeerBundle:Beer')
                     ->findBy([], ['name' => 'ASC']);

        $beerCollection = array_map(function ($aBeer) {
            return $beerCollection[] = new BeerDTO($aBeer);
        }, $beers);

        return $beerCollection;
    }

    /**
      * Bet a Beer entity
      *
      * @ApiDoc(
      *  statusCodes={
      *      200="Returned when successful",
      *      404="Returned when not found",
      * })
      * @return BeerDTO
      */
    public function getBeerAction($id)
    {
        $beer = $this->getDoctrine()->getManager()
                        ->getRepository('MaxpouBeerBundle:Beer')
                        ->find($id);

        if (!$beer) {
            throw new HttpException(404, 'Unable to find this Beer entity');
        }

        return new BeerDTO($beer);
    }
}
