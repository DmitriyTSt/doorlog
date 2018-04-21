<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Bonus;
use AppBundle\Entity\Holiday;
use AppBundle\Entity\User;
use AppBundle\Service\SimpleJsonApi;
use Doctrine\ORM\Mapping\ClassMetadata;
use InvalidArgumentException;
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
     * @Route("/new", name="api_us$metadataer_new")
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
     * @Route("/{id}", name="api_user_edit")
     * @Method("PATCH")
     */
    public function editAction(Request $request, User $user)
    {
        /** @var User $newUser */
        $data1 = json_decode($request->getContent(), true);
        $data = array();
        foreach ($data1 as $fieldName => $result) {
            $data[$this->from_camel_case($fieldName)] = $result;
        }
        $em = $this->getDoctrine()->getManager();
        /** @var ClassMetadata $metadata */
        $metadata = $em->getMetadataFactory()->getMetadataFor(User::class);
        $id = array();
        foreach ($metadata->getIdentifierFieldNames() as $identifier) {
            if (!isset($data[$identifier])) {
                throw new InvalidArgumentException('Missing identifier');
            }
            $id[$identifier] = $data[$identifier];
            unset($data[$identifier]);
        }
        $entity = $em->find($metadata->getName(), $id);
        foreach ($metadata->getFieldNames() as $field) {
            //add necessary checks about field read/write operation feasibility here
            if (isset($data[$field])) {
                //careful! setters are not being called! Inflection is up to you if you need it!
                $metadata->setFieldValue($entity, $field, $data[$field]);
            }
        }
        $em->flush();
        return SimpleJsonApi::createResponseObj($entity);
    }

    function from_camel_case($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
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
     * @Route("/{id}/bonuses_count", name="api_user_bonuses_count")
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
