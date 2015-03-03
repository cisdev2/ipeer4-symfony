<?php

namespace UBC\iPeer\CourseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UBC\iPeer\CourseBundle\Entity\CourseGroup;

/**
 * CourseGroup controller.
 *
 * @Route("/coursegroup")
 */
class CourseGroupController extends Controller
{

    /**
     * Lists all CourseGroup entities.
     *
     * @Route("/", name="coursegroup")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UBCiPeerCourseBundle:CourseGroup')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new CourseGroup entity.
     *
     * @Route("/", name="coursegroup_create")
     * @Method("POST")
     * @Template("UBCiPeerCourseBundle:CourseGroup:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CourseGroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('coursegroup_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CourseGroup entity.
     *
     * @param CourseGroup $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CourseGroup $entity)
    {
        $form = $this->createForm(new CourseGroupType(), $entity, array(
            'action' => $this->generateUrl('coursegroup_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CourseGroup entity.
     *
     * @Route("/new", name="coursegroup_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CourseGroup();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CourseGroup entity.
     *
     * @Route("/{id}", name="coursegroup_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UBCiPeerCourseBundle:CourseGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CourseGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CourseGroup entity.
     *
     * @Route("/{id}/edit", name="coursegroup_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UBCiPeerCourseBundle:CourseGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CourseGroup entity.');
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
    * Creates a form to edit a CourseGroup entity.
    *
    * @param CourseGroup $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CourseGroup $entity)
    {
        $form = $this->createForm(new CourseGroupType(), $entity, array(
            'action' => $this->generateUrl('coursegroup_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CourseGroup entity.
     *
     * @Route("/{id}", name="coursegroup_update")
     * @Method("PUT")
     * @Template("UBCiPeerCourseBundle:CourseGroup:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UBCiPeerCourseBundle:CourseGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CourseGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('coursegroup_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CourseGroup entity.
     *
     * @Route("/{id}", name="coursegroup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UBCiPeerCourseBundle:CourseGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CourseGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('coursegroup'));
    }

    /**
     * Creates a form to delete a CourseGroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('coursegroup_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
