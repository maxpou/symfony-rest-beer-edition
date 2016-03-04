<?php

namespace Maxpou\BeerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Maxpou\BeerBundle\Entity\Brewery;
use Maxpou\BeerBundle\Form\Type\BreweryType;

/**
 * Brewery controller.
 *
 */
class BreweryController extends Controller
{
    /**
     * Lists all Brewery entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $brewerys = $em->getRepository('MaxpouBeerBundle:Brewery')->findAll();

        return $this->render('MaxpouBeerBundle:brewery:index.html.twig', array(
            'brewerys' => $brewerys,
        ));
    }

    /**
     * Creates a new Brewery entity.
     *
     */
    public function newAction(Request $request)
    {
        $brewery = new Brewery();
        $form = $this->createForm(BreweryType::class, $brewery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($brewery);
            $em->flush();

            return $this->redirectToRoute('brewery_show', array('id' => $brewery->getId()));
        }

        return $this->render('MaxpouBeerBundle:brewery:new.html.twig', array(
            'brewery' => $brewery,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Brewery entity.
     *
     */
    public function showAction(Brewery $brewery)
    {
        $deleteForm = $this->createDeleteForm($brewery);

        return $this->render('MaxpouBeerBundle:brewery:show.html.twig', array(
            'brewery' => $brewery,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Brewery entity.
     *
     */
    public function editAction(Request $request, Brewery $brewery)
    {
        $deleteForm = $this->createDeleteForm($brewery);
        $editForm = $this->createForm(BreweryType::class, $brewery);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($brewery);
            $em->flush();

            return $this->redirectToRoute('brewery_edit', array('id' => $brewery->getId()));
        }

        return $this->render('MaxpouBeerBundle:brewery:edit.html.twig', array(
            'brewery' => $brewery,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Brewery entity.
     *
     */
    public function deleteAction(Request $request, Brewery $brewery)
    {
        $form = $this->createDeleteForm($brewery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($brewery);
            $em->flush();
        }

        return $this->redirectToRoute('brewery_index');
    }

    /**
     * Creates a form to delete a Brewery entity.
     *
     * @param Brewery $brewery The Brewery entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Brewery $brewery)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('brewery_delete', array('id' => $brewery->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
