<?php

namespace CPANA\BasicBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CPANA\BasicBlogBundle\Entity\Comment;
use CPANA\BasicBlogBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;

/**
 * Comment controller.
 */
class CommentController extends Controller
{
    /**
     * Add a new comment - show new comment form
     *
     * @param string $blog_id - $id of the article to which the comment will be added
     *
     * @return object Response
     */
    public function newAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $comment = new Comment();
        $comment->setBlog($blog);
        $form   = $this->createForm(new CommentType(), $comment);

        return $this->render(
            'CPANABasicBlogBundle:Comment:form.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
            )
        );
    }

    /**
     * Post the new comment and persist it on Database
     *
     * @param string         $blog_id - $id of the article to which the comment will be added
     * @param Request object $request
     *
     * @return object Response
     */
    public function createAction($blog_id,Request $request)
    {
        $blog = $this->getBlog($blog_id);

        $comment  = new Comment();
        $comment->setBlog($blog);
        $request = $this->getRequest();
        $form    = $this->createForm(new CommentType(), $comment);
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'CPANABasicBlogBundle_blog_show', array(
                    'id' => $comment->getBlog()->getId())
                )
            );
        }

        return $this->render(
            'CPANABasicBlogBundle:Comment:form.html.twig', array(
            'comment' => $comment,
            'form'    => $form->createView()
            )
        );
    }

    /**
     * Get blog article (post) using the blog_id
     *
     * @param string $blog_id - $id of the article to search for
     *
     * @return object Response
     */
    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $blog = $em->getRepository('CPANABasicBlogBundle:Blog')->find($blog_id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $blog;
    }

}
