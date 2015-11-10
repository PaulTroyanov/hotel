<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReviewsController extends Controller
{
    /**
     * @Route("reviews")
     */
    public function reviewsAction()
    {
        return $this->render('reviews/reviews.html.twig');
    }
}