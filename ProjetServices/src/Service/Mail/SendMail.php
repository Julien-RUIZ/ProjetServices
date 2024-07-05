<?php

namespace App\Service\Mail;

use App\Interface\MailInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendMail implements MailInterface
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }
    public function sendMail($mailForm, $userMail, $titre, $text ){
        $email = (new TemplatedEmail())
            ->from($userMail)
            ->to($mailForm)
            ->subject('Relance de la note : '.$titre)
            ->htmlTemplate('emails/reminder.html.twig')
            ->context([
                'title'=>$titre,
                'text'=>$text
            ]);
        $this->mailer->send($email);
    }
}