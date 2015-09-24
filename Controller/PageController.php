<?php

namespace CPANA\BasicBlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use CPANA\BasicBlogBundle\Entity\Enquiry;
use CPANA\BasicBlogBundle\Form\EnquiryType;

class PageController extends Controller
{
    
    /**
     * Handle a contact form
     *
     * @return object Response
     */
    public function contactAction()
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
            
                $message = \Swift_Message::newInstance()
                ->setSubject('Contact enquiry from symblog')
                ->setFrom('explorers.hostel@gmail.com')
                ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                ->setBody($this->renderView('CPANABasicBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                
                $this->get('mailer')->send($message);
                
                $this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('CPANABasicBlogBundle_contact'));
            }
        }

        return $this->render(
            'CPANABasicBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
            )
        );
    }
}
