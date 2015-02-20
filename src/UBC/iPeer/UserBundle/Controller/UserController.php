<?php

namespace UBC\iPeer\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UBC\iPeer\UserBundle\Entity\User;
use UBC\iPeer\UserBundle\Form\UserType;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     *
     * @Route("/", name="user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UBCiPeerUserBundle:User')->findAll();

        return array(
            'users' => $entities,
        );
    }
    /**
     * Creates a new User entity.
     *
     * @Route("/", name="user_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = $this->get('jms_serializer')->deserialize($request->getContent(),'UBC\iPeer\UserBundle\Entity\User', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return array(
            'user' => $entity,
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UBCiPeerUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return array(
            'user' => $entity,
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="user_update")
     * @Method("PUT")
     * @Template("UBCiPeerUserBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        //$entity = $em->getRepository('UBCiPeerUserBundle:User')->find($id);
        $entity = $this->get('jms_serializer')->deserialize($request->getContent(),'UBC\iPeer\UserBundle\Entity\User', 'json');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $em->persist($entity);
        $em->flush();

        return array(
            'user'      => $entity,
        );
    }
    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UBCiPeerUserBundle:User')->find($id);

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('user'));
    }
}
