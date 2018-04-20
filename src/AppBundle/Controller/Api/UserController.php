<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Bonus;
use AppBundle\Entity\Holiday;
use AppBundle\Entity\User;
use AppBundle\Service\SimpleJsonApi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="api_user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return SimpleJsonApi::createResponseObj($users);
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="api_user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="api_user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        return SimpleJsonApi::createResponseObj($user);
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="api_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="api_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Count user's holidays.
     *
     * @Route("/{id}/holidays_count", name="api_user_holidays_count")
     * @Method("GET")
     */
    public function holidaysCountAction(Request $request, User $user) {
        $holidays = $this->getDoctrine()->getManager()->getRepository(Holiday::class)->findBy([
            'user' => $user
        ]);
        return SimpleJsonApi::createResponseObj(count($holidays));
    }

    /**
     * Count user's bonuses.
     *
     * @Route("/{id}/bonuses_count", name="api_user_holidays_count")
     * @Method("GET")
     */
    public function bonusesCountAction(Request $request, User $user) {
        $bonuses = $this->getDoctrine()->getManager()->getRepository(Bonus::class)->findBy([
            'user' => $user
        ]);
        return SimpleJsonApi::createResponseObj(count($bonuses));
    }


    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
