<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RoomsController extends Controller
{
    /**
     * @Route("rooms")
     */
    public function roomsAction()
    {
        return $this->render('rooms/rooms.html.twig');
    }
}