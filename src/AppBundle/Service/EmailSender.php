<?php

namespace AppBundle\Service;

use AppBundle\Entity\ContactMessage;
use Symfony\Bundle\TwigBundle\TwigEngine;

class EmailSender
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var TwigEngine
     */
    private $templating;
    /**
     * @var string
     */
    private $supportEmail;
    /**
     * @var string
     */
    private $fromEmail;

    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer, $templating, $supportEmail, $fromEmail)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->supportEmail = $supportEmail;
        $this->fromEmail = $fromEmail;
    }

    /**
     * @param ContactMessage $contactMessage
     */
    public function sendContactMessage(ContactMessage $contactMessage)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Bug Tracker: New Contact Message')
            ->setTo($this->supportEmail)
            ->setFrom($this->fromEmail)
            ->setReplyTo($contactMessage->getEmail())
            ->setBody(
                $this->templating->render('mail/contact-message.html.twig', ['contactMessage' => $contactMessage]),
                'text/html'
            )
            ->addPart(
                $this->templating->render('mail/contact-message.txt.twig', ['contactMessage' => $contactMessage]),
                'text/plain'
            );

        $this->mailer->send($message);
    }
}
