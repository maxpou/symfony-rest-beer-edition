<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

use Maxpou\BeerBundle\Entity\Beer;
use Maxpou\BeerBundle\Form\BeerType;

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
     * @QueryParam(name="offset", requirements="\d+", nullable=true,
     *     description="Offset from which to start listing breweries.")
     * @QueryParam(name="limit", requirements="\d+", nullable=true,
     *     description="How many breweries to return.")
     *
     * @return array of BeerDTO
     */
    public function getBeersAction(ParamFetcher $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit  = $paramFetcher->get('limit');

        $em    = $this->getDoctrine()->getManager();
        $beers = $em ->getRepository('MaxpouBeerBundle:Beer')
                     ->findBy([], ['name' => 'ASC'], $limit, $offset);

        return $beers;
    }

    /**
      * Bet a Beer entity
      *
      * @ApiDoc(
      *  statusCodes={
      *      200="Returned when successful",
      *      404="Returned when not found"
      * })
      *
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

        return $beer;
    }

    /**
      * Add a Beer
      *
      * @ApiDoc(
      *  statusCodes={
      *       201="Returned when successful",
      *       400="Returned when parameter is wrong"
      *  },
      *  input = {
      *      "class" = "Maxpou\BeerBundle\Form\BeerType",
      *      "name" = ""
      * })
      */
    public function postBeerAction(Request $request)
    {
        $beer = new Beer();

        $form = $this->createForm(BeerType::class, $beer);
        $form->submit($request);

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
}
