<?php

namespace NotificationBundle\Controller;

use EntrepotBundle\Entity\Utilisateur;
use NotificationBundle\Entity\Blog;
use NotificationBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Blog controller.
 *
 * @Route("blog")
 */
class BlogController extends Controller
{
    /**
     * Lists all blog entities.
     *
     * @Route( name="blog_index")
     * @Method("POST")
     */
    public function indexAction()
    { $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em=$this->getDoctrine()->getManager();
        $blogs = $em->createQuery(
            'select n.date date,b.title title, b.description description, b.auteur auteur
            from NotificationBundle:Notification n inner join 
         NotificationBundle:Blog  b  where n.idUser=:item and (b.id = n.parameters)'
        )->setParameter('item',$user)->getResult();

        $data= array();
        foreach ($blogs as $key => $blog)
        {
            $data[$key]['title'] = $blog['title'];
            $data[$key]['description'] = $blog['description'];
            $data[$key]['auteur'] = $blog['auteur'];
            $date=$blog['date'];
            $data[$key]['date'] = $date->format('H:i Y-m-d');
        }
        return  new JsonResponse($data);
    }

    /**
     * Creates a new blog entity.
     *
     * @Route("/new", name="blog_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blog = new Blog();
        $form = $this->createForm('NotificationBundle\Form\BlogType', $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $notification = new Notification();
            $notification
                ->setTitle('New comment')
                ->setDescription($blog->getTitle())
                ->setRoute('blog_show')// I suppose you have a show route for your entity
                ->setParameters($blog)
                ->setIdUser(null);
          $em->persist($notification);
          $em->flush();

        }

        return $this->render('@Notification/blog/new.html.twig', array(
            'blog' => $blog,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blog entity.
     *
     * @Route("/{id}", name="blog_show")
     * @Method("GET")
     */
    public function showAction(Blog $blog)
    {
        $deleteForm = $this->createDeleteForm($blog);

        return $this->render('blog/show.html.twig', array(
            'blog' => $blog,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blog entity.
     *
     * @Route("/{id}/edit", name="blog_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Blog $blog)
    {
        $deleteForm = $this->createDeleteForm($blog);
        $editForm = $this->createForm('NotificationBundle\Form\BlogType', $blog);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_edit', array('id' => $blog->getId()));
        }

        return $this->render('blog/edit.html.twig', array(
            'blog' => $blog,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blog entity.
     *
     * @Route("/{id}", name="blog_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Blog $blog)
    {
        $form = $this->createDeleteForm($blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blog);
            $em->flush();
        }

        return $this->redirectToRoute('blog_index');
    }

    /**
     * Creates a form to delete a blog entity.
     *
     * @param Blog $blog The blog entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Blog $blog)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_delete', array('id' => $blog->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
