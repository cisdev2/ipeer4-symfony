<?php

namespace UBC\iPeer\UserBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UBC\iPeer\UserBundle\Entity\User as User;
use Symfony\Component\HttpFoundation\Response;

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
     * @ApiDoc(
     *  resource=true
     * )
     *
     * @Route("/", name="user")
     * @Method("GET")
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
     * @ApiDoc()
     *
     * @Route("/", name="user_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $user = $this->get('jms_serializer')->deserialize($request->getContent(),'UBC\iPeer\UserBundle\Entity\User', 'json');

        if($user instanceof User === false) {
            return new Response($user,'400');
        }

        $errors = $this->get('validator')->validate($user);

        if(count($errors) > 0) {
            return new Response((string) $errors, '400');
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return array(
            'user' => $user,
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @ApiDoc()
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
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
     * @ApiDoc()
     *
     * @Route("/{id}", name="user_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('jms_serializer')->deserialize($request->getContent(),'UBC\iPeer\UserBundle\Entity\User', 'json');

        if($user instanceof User === false) {
            return new Response($user,'400');
        }

        $errors = $this->get('validator')->validate($user);

        if(count($errors) > 0) {
            return new Response((string) $errors, '400');
        }

        $em->merge($user);

        $em->flush();

        return array(
            'user'      => $user,
        );
    }
    /**
     * Deletes a User entity.
     *
     * @ApiDoc()
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UBCiPeerUserBundle:User')->find($id);

        $em->remove($entity);
        $em->flush();


        return (new Response())->setStatusCode(204);
    }
}
