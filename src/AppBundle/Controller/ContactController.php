<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ContactForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("contact")
     */
    public function contactAction(Request $request)
    {
        $contactForm = new ContactForm();

        $form = $this->createFormBuilder($contactForm)
            ->add('username', 'text', array('label' => 'Your name '))
            ->add('email', 'email', array('label' => 'Your email '))
            ->add('message', 'textarea', array('label' => 'Your message'))
            ->add('save', 'submit', array('label' => 'Send message'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->addFlash(
                'notice',
                'Your message has been send! Thank you, ' . $form->get('username')->getData() . '!'
            );
            return $this->redirectToRoute("home_page");
        }

        return $this->render('contact/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}