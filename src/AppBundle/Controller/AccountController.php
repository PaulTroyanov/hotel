<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Messages;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{
    /**
     * @Route("/account", name="user_account")
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession()->get('user');
        return $this->render('account/index.html.twig', array('user' => $session));
    }

    /**
     * @Route("/account/messages")
     */
    public function messagesAction(Request $request)
    {
        $session = $request->getSession()->get('user');
        return $this->render('account/messages.html.twig', array(
                'messages' => $this->getDoctrine()->getRepository('AppBundle:Messages')->findBy(array('email' => $session['email']))
            )
        );
    }
}