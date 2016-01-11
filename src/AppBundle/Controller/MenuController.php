<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\User;
use AppBundle\Entity\LoginForm;

class MenuController extends Controller
{
    /**
     * @Route("index", name="home_page")
     */
    public function indexAction()
    {
        return $this->render('menu/index.html.twig');
    }

    /**
     * @Route("login")
     */
    public function loginAction(Request $request)
    {
        $loginForm = new LoginForm();

        $form = $this->createFormBuilder($loginForm)
            ->add('email', 'email', array('label' => 'Your email '))
            ->add('password', 'password', array('label' => 'Your password '))
            ->add('save', 'submit', array('label' => 'Log in'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var User $user */
            $user = $this->getDoctrine()
                         ->getRepository('AppBundle:User')
                         ->findOneBy(
                             array(
                                'email' => $loginForm->getEmail(),
                                'password' => $loginForm->getPassword()
                            )
                         );

            if($user) {
                $session = $request->getSession();

                $session->set('user', array(
                    'name' => $user->getName(),
                    'surname' => $user->getSurname(),
                    'email' => $user->getEmail(),
                    'passportId' => $user->getPassportId(),
                    'phoneNumber' => $user->getPhoneNumber(),
                    'password' => $user->getPassword()
                ));
                if ($user->getEmail() == 'admin@example.com') {
                    $this->addFlash(
                        'notice',
                        'Hello! You\'re have admin permissions!'
                    );
                } else {
                    $this->addFlash(
                        'notice',
                        'Welcome!'
                    );
                }
                return $this->redirectToRoute("home_page");
            } else {
                $this->addFlash(
                    'error',
                    'There is no such user!'
                );
                return $this->redirectToRoute("home_page");
            }
        }
        return $this->render('menu/login.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("logout")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction(Request $request)
    {
        $session = $request->getSession();
        $session->remove('user');

        return $this->redirectToRoute("home_page");
    }

    /**
     * @Route("registration")
     */
    public function registrationAction(Request $request)
    {
        $registrationForm = new User();

        $form = $this->createFormBuilder($registrationForm)
            ->add('name', 'text', array('label' => 'Your name '))
            ->add('surname', 'text', array('label' => 'Your surname '))
            ->add('email', 'email', array('label' => 'Your email '))
            ->add('passportId', 'text', array('label' => 'Your passport id'))
            ->add('phoneNumber', 'text', array('label' => 'Your phone number '))
            ->add('password', 'password', array('label' => 'Your password '))
            ->add('save', 'submit', array('label' => 'Sing up'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registrationForm);
            $em->flush();

            $session = $request->getSession();

            $session->set('user', array(
                'name' => $registrationForm->getName(),
                'surname' => $registrationForm->getSurname(),
                'email' => $registrationForm->getEmail(),
                'passportId' => $registrationForm->getPassportId(),
                'phoneNumber' => $registrationForm->getPhoneNumber(),
                'password' => $registrationForm->getPassword()
            ));

            $this->addFlash(
                'notice',
                'Your registration is success! Thank you, ' . $form->get('name')->getData() . '!'
            );
            return $this->redirectToRoute("home_page");
        }

        return $this->render('menu/registration.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
