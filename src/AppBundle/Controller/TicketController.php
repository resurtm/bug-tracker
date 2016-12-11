<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ticket;
use AppBundle\Form\TicketType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TicketController extends Controller
{
    /**
     * @Route("/tickets", name="tickets")
     */
    public function listAction()
    {
        return $this->render('ticket/list.html.twig');
    }

    /**
     * @Route("/ticket/{id}-{slug}", name="view_ticket", requirements={"id": "\d+"})
     */
    public function viewAction($id, $slug)
    {
        $ticket = $this->getDoctrine()
            ->getRepository('AppBundle:Ticket')
            ->findOneBy(['id' => $id, 'slug' => $slug]);

        if (!$ticket) {
            throw $this->createNotFoundException('Requested ticket cannot be found!');
        }

        return $this->render('ticket/view.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * @Route("/create-ticket", name="create_ticket")
     */
    public function createAction(Request $request)
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();

            $this->addFlash('success', '<strong>Thank you!</strong> Your ticket has been successfully created.');
            return $this->redirectToRoute('view_ticket', ['id' => $ticket->getId(), 'slug' => $ticket->getSlug()]);
        }

        return $this->render('ticket/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
