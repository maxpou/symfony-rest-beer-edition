<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Options;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializationContext;

use Maxpou\BeerBundle\Entity\Brewery;
use Maxpou\BeerBundle\Form\Type\BreweryType;

/**
 * Branche controller.
 * @RouteResource("brewery")
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
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit  = $paramFetcher->get('limit');

        $em        = $this->getDoctrine()->getManager();
        $breweries = $em  ->getRepository('MaxpouBeerBundle:Brewery')
                          ->findBy([], ['name' => 'ASC'], $limit, $offset);

        $context = SerializationContext::create()->setGroups(array('Default','list'));
        $view = $this->view($breweries, 200);
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
      * Get a Brewery entity
      * @ApiDoc(
      *  statusCodes={
      *      200="Returned when successful",
      *      400="Returned when parameter is wrong",
      *      404="Returned when not found"
      * })
      */
    public function getAction($breweryId)
    {
    //   * @Route(requirements={
    //   *   "breweryId": "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"
    //   * })
    //   * @param UUID $breweryId Brewery Id
        $brewery = $this->getDoctrine()->getManager()
                        ->getRepository('MaxpouBeerBundle:Brewery')
                        ->find($breweryId);

        if (!$brewery) {
            throw new HttpException(404, 'Unable to find this Brewery entity');
        }

        $context = SerializationContext::create()->setGroups(array('Default','details'));
        $view = $this->view($brewery, 200);
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
      * Add a Brewery
      *
      * @ApiDoc(
      *  statusCodes={
      *      201="Returned when successful",
      *      400="Returned when parameter is wrong"
      *  },
      *  input = {
      *      "class" = "Maxpou\BeerBundle\Form\Type\BreweryType",
      *      "groups"={"list"},
      *      "name" = ""
      *  },
      * )
      */
    public function postAction(Request $request)
    {
        $brewery = new Brewery();

        $form = $this->createForm(BreweryType::class, $brewery);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($brewery);
            $em->flush();

            $view = $this->view($brewery, 201);
            $context = SerializationContext::create()->setGroups(array('Default','details'));
            $view->setSerializationContext($context);
        } else {
            $view = $this->view($form, 400);
        }


        return $this->handleView($view);
    }

    /**
     * Update an existing Brewery (cannot create here, sorry)
     *
     * @ApiDoc(
     *  statusCodes={
     *      204="Returned when successful",
     *      404="Returned when not found",
     *      400="Returned when parameter is wrong"
     * },
     * input = {
     *     "class" = "Maxpou\BeerBundle\Form\Type\BreweryType",
     *     "name" = ""
     * })
     */
    public function putAction(Request $request, $breweryId)
    {
    //  * @Route(requirements={
    //  *   "breweryId": "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"
    //  * })
    //  * @param UUID $breweryId Brewery Id
        $brewery = $this->getDoctrine()->getManager()
                        ->getRepository('MaxpouBeerBundle:Brewery')
                        ->find($breweryId);

        if (!$brewery) {
            throw new HttpException(404, 'Unable to find this Brewery entity');
        }

        $form = $this->createForm(BreweryType::class, $brewery);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($brewery);
            $em->flush();

            $view = $this->view(null, 204);
            return $this->handleView($view);
        } else {
            $view = $this->view($form, 400);
        }

        return $view;
    }

    /**
     * Delete brewery
     *
     * @ApiDoc(
     *  statusCodes={
     *      204="Returned when successful"
     * })
     * @Route(requirements={
     *   "breweryId": "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"
     * })
     * @param UUID $breweryId Brewery Id
     */
    public function deleteAction($breweryId)
    {
        $brewery = $this->getDoctrine()->getManager()
                        ->getRepository('MaxpouBeerBundle:Brewery')
                        ->find($breweryId);

        if ($brewery) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($brewery);
            $em->flush();
        }

        return $this->view(null, 204);
    }



    /**
     * Delete all breweries
     * Todo: do it properly (reduce SQL request!)
     *
     * @ApiDoc(
     *  statusCodes={
     *      204="Returned when successful"
     * })
     */
    public function cdeleteAction()
    {
        $em = $this->getDoctrine()->getManager();

        $breweries = $em->getRepository('MaxpouBeerBundle:Brewery')
                        ->findAll();

        if ($breweries) {
            foreach ($breweries as $brewery) {
                $em->remove($brewery);
            }
            $em->flush();
        }

        return $this->view(null, 204);
    }

    /**
     * Options
     *
     * @ApiDoc(
     *  statusCodes={
     *      200="Returned when successful"
     * })
     */
    public function coptionsAction()
    {
        $response = new Response();
        $response->headers->set('Allow', 'OPTIONS, GET, POST, DELETE');
        return $response;
    }
}
