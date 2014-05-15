<?php

namespace SON\CatalogoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SON\CatalogoBundle\Entity\Catalogo;
use SON\CatalogoBundle\Form\CatalogoType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Catalogo controller.
 *
 * @Route("/catalogo")
 */
class CatalogoController extends Controller
{

    /**
     * Lists all Catalogo entities.
     *
     * @Route("/", name="catalogo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CatalogoBundle:Catalogo')->findAll();
        $entitie = $em->getRepository('CatalogoBundle:Catalogo')->find(3);
        $user = $em->getRepository('UserBundle:User')->findOneByUsername('user');
        $us = $this->get('security.context')->getToken()->getUser();
        var_dump(
            $entitie->getAutor(),
            $entities[0]->getAutor(),
            $user,
            $this->getUser(),
            $us,
            $entities[0]->getAutor() == $user,
            $entities[0]->getAutor() == $this->getUser(),
            $us == $this->getUser(),
            $us == $entities[0]->getAutor()
        );
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Catalogo entity.
     *
     * @Route("/", name="catalogo_create")
     * @Method("POST")
     * @Template("CatalogoBundle:Catalogo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Catalogo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $this->getUser();

            $entity->setAutor($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('catalogo_show', array('slug' => $entity->getSlug())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Catalogo entity.
    *
    * @param Catalogo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Catalogo $entity)
    {
        $form = $this->createForm(new CatalogoType(), $entity, array(
            'action' => $this->generateUrl('catalogo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Catalogo entity.
     *
     * @Route("/new", name="catalogo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $securityContext = $this->get('security.context');
        if (!$securityContext->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Somente Admins podem acessar essa função');
        }
        $entity = new Catalogo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Catalogo entity.
     *
     * @Route("/{slug}", name="catalogo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CatalogoBundle:Catalogo')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogo entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Catalogo entity.
     *
     * @Route("/{id}/edit", name="catalogo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogo entity.');
        }

        $this->verificaAutor($entity);

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Catalogo entity.
    *
    * @param Catalogo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Catalogo $entity)
    {
        $form = $this->createForm(new CatalogoType(), $entity, array(
            'action' => $this->generateUrl('catalogo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Catalogo entity.
     *
     * @Route("/{id}", name="catalogo_update")
     * @Method("PUT")
     * @Template("CatalogoBundle:Catalogo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);

        $this->verificaAutor($entity);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('catalogo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Catalogo entity.
     *
     * @Route("/{id}", name="catalogo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);

            $this->verificaAutor($entity);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Catalogo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('catalogo'));
    }

    /**
     * Creates a form to delete a Catalogo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('catalogo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    private function verificaAutor(Catalogo $catalogo)
    {
        $user = $this->getUser();
        if ($user->getId() != $catalogo->getAutor()->getId()) {
            throw new AccessDeniedException('Você não é o autor desse catálogo!');
        }
    }
}
