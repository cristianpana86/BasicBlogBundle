<?php
namespace CPANA\BasicBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CPANA\BasicBlogBundle\Entity\Blog;
use CPANA\BasicBlogBundle\Utils\RandomString;

class AdminController extends Controller
{
    /**
     * Admin home view. From here administrate blog posts and comments
     *
     * @return object Response 
     */
    public function indexAdminAction()
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $blogs = $em->getRepository('CPANABasicBlogBundle:Blog')
            ->getBlogs();

        return $this->render(
            'CPANABasicBlogBundle:Admin:indexadmin.html.twig', array(
            'blogs' => $blogs
            )
        );
    }
    
    /**
     * Manage comments admin view
     *
     * @return object Response
     */
    public function commentsAction()
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $comments = $em->getRepository('CPANABasicBlogBundle:Comment')
            ->getAllCommentsForBlog();

        return $this->render(
            'CPANABasicBlogBundle:Admin:comments.html.twig', array(
            'comments' => $comments
            )
        );
    }
    /**
     * Edit a blog entry
     *
     * @param string         $id      - $id of the article to be edited
     * @param Request object $request
     *
     * @return object Response
     */
    public function editAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('CPANABasicBlogBundle:Blog')->find($id);
        
        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        
        $form = $this->createFormBuilder($blog)
            ->add('title', 'text')
            ->add('author', 'text')
            ->add('blog', 'textarea')
            ->getForm();

        $form->handleRequest($request); 
     
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute('CPANABasicBlogBundle_admin_add_success');
        }    
    
        $build['form'] = $form->createView();
        $build['blog_id'] = $id;
        return $this->render('CPANABasicBlogBundle:Admin:edit.html.twig', $build);
            
    }
    
    /**
     * Delete a blog entry
     *
     * @param string         $id      - $id of the article to be edited
     * @param Request object $request
     *
     * @return object Response
     */
    public function deleteAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('CPANABasicBlogBundle:Blog')->find($id);
        
        $parameter['title']=$blog->getTitle();
        $parameter['blog_id']=$id;
        
        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        
        $em->remove($blog);
        $em->flush();
                
        return $this->render('CPANABasicBlogBundle:Admin:deletesuccess.html.twig', $parameter);
            
    }
    /**
     * Add a blog entry
     *
     * @param Request object $request
     *
     * @return object Response
     */
    public function addAction(Request $request)
    {
        $blog = new Blog();
        $blog->setCreated(new \DateTime());
    
        $form = $this->createFormBuilder($blog)
            ->add('title', 'text')
            ->add('author', 'text', array('data' => 'Cristian',))
            ->add('image', 'file', array('mapped'=>false,'required' => false,))
            ->add('tags', 'text')
            ->add('blog', 'textarea')
            ->getForm();

        $form->handleRequest($request); 
        //\Doctrine\Common\Util\Debug::dump($form['image']->getData());
        if ($form->isValid()) {
			$newFilename='';
			
			if (!is_null($form['image']->getData())) {
				$newFilename =RandomString::randomStr() . $form['image']->getData()->getClientOriginalName();
				// Handle picture upload process
				$uploadDir=dirname($this->container->getParameter('kernel.root_dir')) . '/web/bundles/basicblogbundle/images/';
				$form['image']->getData()->move($uploadDir, $newFilename);
				// End of upload
				
            } 
            $blog->setImage($newFilename);
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            
            return $this->redirectToRoute('CPANABasicBlogBundle_admin_add_success');
        }    
    
        $build['form'] = $form->createView();
        return $this->render('CPANABasicBlogBundle:Admin:add.html.twig', $build);
        
    }
    /**
     * Show success message after posting new article
     *
     * @return object Response
     */
    public function addSuccessAction()
    {
        return $this->render('CPANABasicBlogBundle:Admin:addsuccess.html.twig');
    }
    /**
     * Delete a comment entry
     *
     * @param string         $id      - $id of the comment to be deleted
     * @param Request object $request
     *
     * @return object Response
     */
    public function deleteCommentAction($id,Request $request)
    {    
        $em = $this->getDoctrine()->getManager();

        $comment = $em->getRepository('CPANABasicBlogBundle:Comment')->find($id);
        
                
        if (!$comment) {
            throw $this->createNotFoundException('Unable to find comment.');
        }
        
        $em->remove($comment);
        $em->flush();
                
        return $this->render('CPANABasicBlogBundle:Admin:delete_comment_success.html.twig');
            
    }
    
    /**
     * Approve  a comment entry
     *
     * @param string         $id      - $id of the comment to be approved
     * @param Request object $request
     *
     * @return object Response
     */
    public function approveCommentAction($id,Request $request)
    {    
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('CPANABasicBlogBundle:Comment')->find($id);
        
        if (!$comment) {
            throw $this->createNotFoundException('Unable to find comment.');
        }
        $comment->setApproved(true);
        $em->persist($comment);
        $em->flush();
        
        return $this->redirectToRoute('CPANABasicBlogBundle_admin_manage_comments');
        
            
    }
    /**
     * Unapprove  a comment entry
     *
     * @param string         $id      - $id of the comment to be unapproved
     * @param Request object $request
     *
     * @return object Response
     */
    public function unapproveCommentAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('CPANABasicBlogBundle:Comment')->find($id);
                        
        if (!$comment) {
            throw $this->createNotFoundException('Unable to find comment.');
        }
        $comment->setApproved(false);
        $em->persist($comment);
        $em->flush();
                
        return $this->redirectToRoute('CPANABasicBlogBundle_admin_manage_comments');
            
    }
    
}
