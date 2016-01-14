<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ContactForm;
use AppBundle\Entity\Messages;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("contact", name="contact_page")
     */
    public function contactAction(Request $request)
    {
        $session = $request->getSession()->get('user');
        $contactForm = new ContactForm();

        $form = $this->createFormBuilder($contactForm)
            ->add('username', 'text', array('label' => 'Your name '))
            ->add('email', 'email', array('label' => 'Your email '))
            ->add('message', 'textarea', array('label' => 'Your message'))
            ->add('save', 'submit', array('label' => 'Send message'))
            ->getForm();

        if (!empty($session)) {
            $form->get('username')->setData($session['name']);
            $form->get('email')->setData($session['email']);
        }
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactForm);
            $em->flush();

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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("contact/messages", name="messages_list_page")
     */
    public function listMessagesAction()
    {
        return $this->render('contact/messages.html.twig', array(
                'messagesList' => $this->getDoctrine()->getRepository('AppBundle:ContactForm')->findAll()
            )
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("contact/reply")
     */
    public function replyAction(Request $request)
    {
        $replyTo = $request->getSession()->get('user');
        $reply = new Messages();
        $reply->setEmail($request->query->get('email'));
        $reply->setReplyTo($replyTo['email']);

        $form = $this->createFormBuilder($reply)
            ->add('message', 'textarea', array('label' => 'Message'))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reply);
            $em->flush();

            $this->addFlash(
                'notice',
                'The message has been send!'
            );

            if ($replyTo['email'] != 'admin@example.com') {
                return $this->redirectToRoute("user_account");
            }

            return $this->redirectToRoute("messages_list_page");
        }

        return $this->render('/contact/reply.html.twig', array(
            'form' => $form->createView(),
            'email' => $reply->getEmail()
        ));
    }

}