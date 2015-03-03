<?php

namespace UBC\iPeer\CourseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UBC\iPeer\CourseBundle\Entity\Enrollment;

/**
 * Enrollment controller.
 *
 * @Route("/enrollment")
 */
class EnrollmentController extends Controller
{

    /**
     * Lists all Enrollment entities.
     *
     * @Route("/", name="enrollment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UBCiPeerCourseBundle:Enrollment')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Enrollment entity.
     *
     * @Route("/", name="enrollment_create")
     * @Method("POST")
     * @Template("UBCiPeerCourseBundle:Enrollment:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Enrollment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('enrollment_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Enrollment entity.
     *
     * @param Enrollment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Enrollment $entity)
    {
        $form = $this->createForm(new EnrollmentType(), $entity, array(
            'action' => $this->generateUrl('enrollment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Enrollment entity.
     *
     * @Route("/new", name="enrollment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Enrollment();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Enrollment entity.
     *
     * @Route("/{id}", name="enrollment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UBCiPeerCourseBundle:Enrollment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Enrollment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Enrollment entity.
     *
     * @Route("/{id}/edit", name="enrollment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UBCiPeerCourseBundle:Enrollment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Enrollment entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Enrollment entity.
    *
    * @param Enrollment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Enrollment $entity)
    {
        $form = $this->createForm(new EnrollmentType(), $entity, array(
            'action' => $this->generateUrl('enrollment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Enrollment entity.
     *
     * @Route("/{id}", name="enrollment_update")
     * @Method("PUT")
     * @Template("UBCiPeerCourseBundle:Enrollment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UBCiPeerCourseBundle:Enrollment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Enrollment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('enrollment_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Enrollment entity.
     *
     * @Route("/{id}", name="enrollment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UBCiPeerCourseBundle:Enrollment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Enrollment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('enrollment'));
    }

    /**
     * Creates a form to delete a Enrollment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('enrollment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
