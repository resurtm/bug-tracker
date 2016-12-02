<?php

namespace AppBundle\Service;

use AppBundle\Entity\ContactMessage;

class EmailSender
{
    private $mailer;
    private $supportEmail;
    private $fromEmail;

    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer, $supportEmail, $fromEmail)
    {
        $this->mailer = $mailer;
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
            ->setFrom($this->supportEmail)
            ->setTo($this->fromEmail)
            ->setReplyTo($contactMessage->getEmail())
            ->setBody(
                'html',
                'text/html'
            )
            ->addPart(
                'plain',
                'text/plain'
            );

        $this->mailer->send($message);
    }
}
