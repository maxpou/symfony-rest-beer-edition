<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Maxpou\BeerBundle\Entity\Brewery;
use Maxpou\BeerBundle\Form\BreweryType;

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

        return $breweries;
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

        return $brewery;
    }

    /**
      * Add a Brewery
      *
      * @ApiDoc(
      *  statusCodes={
      *      201="Returned when successful",
      *      400="Returned when parameter is wrong"
      * },
      * input = {
      *     "class" = "Maxpou\BeerBundle\Form\BreweryType"
      * })
      */
    public function postBrewerieAction(Request $request)
    {
        $brewery = new Brewery();

        $form = $this->createForm(BreweryType::class, $brewery);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($brewery);
            $em->flush();

            $view = $this->view($brewery, 201);
            return $this->handleView($view);
        }

        return $form;
    }

    /**
     * Update an existing Brewery (cannot create here, sorry)
     *
     * @ApiDoc(
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when parameter is wrong"
     * },
     * input = {
     *     "class" = "Maxpou\BeerBundle\Form\BreweryType",
     *     "name" = "",
     * })
     */
    public function putBrewerieAction(Request $request, $id)
    {
        $brewery = $this->getDoctrine()->getManager()
                        ->getRepository('MaxpouBeerBundle:Brewery')
                        ->find($id);

        if (!$brewery) {
            throw new HttpException(404, 'Unable to find this Brewery entity');
        }

        //remember childs
        $ownBeers = $brewery->getBeers();
        $brewery = new Brewery($id);
        
        foreach ($ownBeers as $aBeer) {
            return $brewery->addBeer($aBeer);
        }


        $form = $this->createForm(BreweryType::class, $brewery);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($brewery);
            $em->flush();

            $view = $this->view($brewery, 200);
            return $this->handleView($view);
        }

        return $form;

    }
}
