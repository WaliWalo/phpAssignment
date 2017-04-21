<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\Steps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Step controller.
 *
 * @Route("steps")
 */
class StepsController extends Controller
{
    /**
     * Lists all step entities.
     *
     * @Route("/", name="steps_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $steps = $em->getRepository('AppBundle:Steps')->findAll();

        return $this->render('steps/index.html.twig', array(
            'steps' => $steps,
        ));
    }

    /**
     * Creates a new step entity.
     * @Security("has_role('ROLE_user')")
     * @Route("/new/{id}", name="steps_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Recipe $recipe)
    {
        $step = new Steps();
        $step->setRecipeID($recipe);

        $form = $this->createForm('AppBundle\Form\StepsType', $step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($step);
            $em->flush($step);

            return $this->redirectToRoute('steps_show', array('id' => $step->getId()));
        }

        return $this->render('steps/new.html.twig', array(
            'step' => $step,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a step entity.
     *
     * @Route("/{id}", name="steps_show")
     * @Method("GET")
     */
    public function showAction(Steps $step)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $deleteForm = $this->createDeleteForm($step);

        return $this->render('steps/show.html.twig', array(
            'step' => $step,
            'delete_form' => $deleteForm->createView(),
            'user' => $user,
        ));
    }

    /**
     * Displays a form to edit an existing step entity.
     *
     * @Route("/{id}/edit", name="steps_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Steps $step)
    {
        $deleteForm = $this->createDeleteForm($step);
        $editForm = $this->createForm('AppBundle\Form\StepsType', $step);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('steps_edit', array('id' => $step->getId()));
        }

        return $this->render('steps/edit.html.twig', array(
            'step' => $step,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a step entity.
     *
     * @Route("/{id}", name="steps_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Steps $step)
    {
        $form = $this->createDeleteForm($step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($step);
            $em->flush($step);
        }

        return $this->redirectToRoute('steps_index');
    }

    /**
     * Creates a form to delete a step entity.
     *
     * @param Steps $step The step entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Steps $step)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('steps_delete', array('id' => $step->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
