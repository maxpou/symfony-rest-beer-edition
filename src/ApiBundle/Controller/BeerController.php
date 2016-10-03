<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Maxpou\BeerBundle\Entity\Beer;
use Maxpou\BeerBundle\Form\Type\BeerApiType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Beer controller.
 *
 * @RouteResource("beer")
 */
class BeerController extends FOSRestController
{
    /**
     * Get all Beers entities.
     *
     * @ApiDoc(
     *  statusCodes={
     *      200="Returned when successful"
     * })
     * @QueryParam(name="offset", requirements="\d+", nullable=true,
     *     description="Offset from which to start listing breweries.")
     * @QueryParam(name="limit", requirements="\d+", nullable=true,
     *     description="How many breweries to return.")
     *
     * @param UUID $breweryId Brewery Id
     */
    public function cgetAction($breweryId, ParamFetcher $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');

        $em = $this->getDoctrine()->getManager();
        $beers = $em->getRepository('MaxpouBeerBundle:Beer')
                     ->findBy(
                         ['brewery' => $breweryId],
                         ['name' => 'ASC'],
                         $limit,
                         $offset
                     );

        return $beers;
    }

    /**
     * Get a Beer entity.
     *
     * @ApiDoc(
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when not found"
     * })
     *
     * @param UUID $breweryId Brewery Id
     * @param UUID $beerId    Beer Id
     */
    public function getAction($breweryId, $beerId)
    {
        $brewery = $this->getDoctrine()->getManager()
                        ->getRepository('MaxpouBeerBundle:Brewery')
                        ->find($breweryId);

        if (!$brewery) {
            throw new HttpException(404, 'Unable to find this Brewery entity');
        }

        $beer = $this->getDoctrine()->getManager()
                        ->getRepository('MaxpouBeerBundle:Beer')
                        ->find($beerId);

        if (!$beer) {
            throw new HttpException(404, 'Unable to find this Beer entity');
        }

        return $beer;
    }

    /**
     * Add a Beer.
     *
     * @ApiDoc(
     *  statusCodes={
     *       201="Returned when successful",
     *       400="Returned when parameter is wrong"
     *  },
     *  input = {
     *      "class" = "Maxpou\BeerBundle\Form\Type\BeerApiType",
     *      "name"  = ""
     * })
     *
     * @param UUID $breweryId Brewery Id
     */
    public function postAction($breweryId, Request $request)
    {
        $brewery = $this->getDoctrine()->getManager()
                        ->getRepository('MaxpouBeerBundle:Brewery')
                        ->find($breweryId);

        if (!$brewery) {
            throw new HttpException(404, 'Unable to find this Brewery entity');
        }

        $beer = new Beer();
        $beer->setBrewery($brewery);

        $form = $this->createForm(BeerApiType::class, $beer);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($beer);
            $em->flush();

            $view = $this->view($beer, 201);
        } else {
            $view = $this->view($form, 400);
        }

        return $this->handleView($view);
    }

    /**
     * Update an existing Beer (cannot create here, sorry).
     *
     * @ApiDoc(
     *  statusCodes={
     *      204="Returned when successful",
     *      404="Returned when not found",
     *      400="Returned when parameter is wrong"
     * },
     * input = {
     *     "class" = "Maxpou\BeerBundle\Form\Type\BeerApiType",
     *     "name"  = ""
     * })
     *
     * @param UUID $breweryId Brewery Id
     * @param UUID $beerId    Beer Id
     */
    public function putAction($breweryId, Request $request, $beerId)
    {
        $beer = $this->getDoctrine()->getManager()
                     ->getRepository('MaxpouBeerBundle:Beer')
                     ->find($beerId);

        if (!$beer) {
            throw new HttpException(404, 'Unable to find this Beer entity');
        }

        $form = $this->createForm(BeerApiType::class, $beer);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($beer);
            $em->flush();

            $view = $this->view(null, 204);

            return $this->handleView($view);
        } else {
            $view = $this->view($form, 400);
        }

        return $view;
    }

    /**
     * Delete brewery.
     *
     * @ApiDoc(
     *  statusCodes={
     *      204="Returned when successful"
     * })
     *
     * @param UUID $breweryId Brewery Id
     * @param UUID $beerId    Beer Id
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function deleteAction($breweryId, $beerId)
    {
        $beer = $this->getDoctrine()->getManager()
                     ->getRepository('MaxpouBeerBundle:Beer')
                     ->find($beerId);

        if ($beer) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($beer);
            $em->flush();
        }

        return $this->view(null, 204);
    }

    /**
     * Delete all beers from an existing brewery entity.
     *
     * @ApiDoc(
     *  statusCodes={
     *      204="Returned when successful"
     * })
     *
     * @param UUID $breweryId Brewery Id
     */
    public function cdeleteAction($breweryId)
    {
        $em = $this->getDoctrine()->getManager();
        $brewery = $em->getRepository('MaxpouBeerBundle:Brewery')
                      ->find($breweryId);

        if (!$brewery) {
            throw new HttpException(404, 'Unable to find this Brewery entity');
        }

        $em->getRepository('MaxpouBeerBundle:Beer')
           ->deleteAll($brewery);

        return $this->view(null, 204);
    }

    /**
     * Options.
     *
     * @ApiDoc(
     *  statusCodes={
     *      200="Returned when successful"
     * })
     *
     * @param UUID $breweryId Brewery Id
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function coptionsAction($breweryId)
    {
        $response = new Response();
        $response->headers->set('Allow', 'OPTIONS, GET, POST, DELETE');

        return $response;
    }
}
