<?php
namespace CPANA\BasicBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Blog controller.
 */
class BlogController extends Controller
{
	/**
     * Generates the home view of the blog, listing all articles
     *
     * @todo - add pagination
     *
     * @return object Response
     */
    public function blogHomeAction($currentPage=1)
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $posts = $em->getRepository('CPANABasicBlogBundle:Blog')
            ->getAllPosts($currentPage);
		
		$iterator=$posts->getIterator();
		$limit = 3;
		$maxPages = ceil($posts->count()/$limit);
		$thisPage = $currentPage;
		
        return $this->render(
            'CPANABasicBlogBundle:Blog:home.html.twig', array(
            'blogs' => $iterator, 
			'maxPages'=>$maxPages, 
			'thisPage' => $thisPage,
            )
        );
    }
    /**
     * Show a blog entry (post)
     *
     * @param  string $id 
     * @return object Response 
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('CPANABasicBlogBundle:Blog')->find($id);
 
        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        $comments = $em->getRepository('CPANABasicBlogBundle:Comment')
            ->getCommentsForBlog($blog->getId());

        return  $this->render(
            'CPANABasicBlogBundle:Blog:show.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
            )
        );
    }
}
