<?php

namespace Maxpou\BeerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Maxpou\BeerBundle\Entity\Beer;
use Maxpou\BeerBundle\Form\BeerType;

/**
 * Beer controller.
 *
 */
class BeerController extends Controller
{
    /**
     * Lists all Beer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $beers = $em->getRepository('MaxpouBeerBundle:Beer')->findAll();

        return $this->render('MaxpouBeerBundle:beer:index.html.twig', array(
            'beers' => $beers,
        ));
    }

    /**
     * Creates a new Beer entity.
     *
     */
    public function newAction(Request $request)
    {
        $beer = new Beer();
        $form = $this->createForm(BeerType::class, $beer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($beer);
            $em->flush();

            return $this->redirectToRoute('beer_show', array('id' => $beer->getId()));
        }

        return $this->render('MaxpouBeerBundle:beer:new.html.twig', array(
            'beer' => $beer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Beer entity.
     *
     */
    public function showAction(Beer $beer)
    {
        $deleteForm = $this->createDeleteForm($beer);

        return $this->render('MaxpouBeerBundle:beer:show.html.twig', array(
            'beer'        => $beer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Beer entity.
     *
     */
    public function editAction(Request $request, Beer $beer)
    {
        $deleteForm = $this->createDeleteForm($beer);
        $editForm = $this->createForm(BeerType::class, $beer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($beer);
            $em->flush();

            return $this->redirectToRoute('beer_edit', array('id' => $beer->getId()));
        }

        return $this->render('MaxpouBeerBundle:beer:edit.html.twig', array(
            'beer'        => $beer,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Beer entity.
     *
     */
    public function deleteAction(Request $request, Beer $beer)
    {
        $form = $this->createDeleteForm($beer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($beer);
            $em->flush();
        }

        return $this->redirectToRoute('beer_index');
    }

    /**
     * Creates a form to delete a Beer entity.
     *
     * @param Beer $beer The Beer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Beer $beer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('beer_delete', array('id' => $beer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
