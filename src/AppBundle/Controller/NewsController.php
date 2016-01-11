<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    /**
     * @Route("/news")
     */
    public function newsAction()
    {
        return $this->render('news/news.html.twig', array(
            'newsList' => $this->getDoctrine()->getRepository('AppBundle:News')->findAll()
            )
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/news/create", name="create_news_page")
     */
    public function createNewsAction(Request $request)
    {
        $newsForm = new News();

        $form = $this->createFormBuilder($newsForm)
            ->add('head', 'text', array('label' => 'Head'))
            ->add('body', 'textarea', array('label' => 'Body'))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsForm);
            $em->flush();

            $this->addFlash(
                'notice',
                'The changes were saved'
            );
            return $this->redirectToRoute("create_news_page");
        }

        return $this->render('/news/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}