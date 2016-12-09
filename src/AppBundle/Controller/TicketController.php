<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TicketController extends Controller
{
    /**
     * @Route("/tickets", name="tickets")
     */
    public function listAction(Request $request)
    {
        return $this->render('ticket/list.html.twig');
    }

    /**
     * @Route("/create-ticket", name="create_ticket")
     */
    public function createAction(Request $request)
    {
        return $this->render('ticket/create.html.twig');
    }
}
