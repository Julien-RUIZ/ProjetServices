<?php

namespace App\Controller\Contact;

use App\Entity\ContactDTO;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function ContactMail(Request $request, MailerInterface $mailer): Response
    {
        $DTO = new ContactDTO();
        $form = $this->createForm(ContactType::class, $DTO);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            try {
                $email = (new TemplatedEmail())
                    ->from($DTO->Email)
                    ->to($DTO->Service)
                    ->subject('Contact')
                    ->htmlTemplate('emails/signup.html.twig')
                    ->context([
                        'DTO'=>$DTO
                    ]);
                $mailer->send($email);
                $this->addFlash('success', 'Votre email a bien été envoyé');
                return $this->redirectToRoute('app_home');

            }catch (TransportExceptionInterface $transportException){
                $this->addFlash('danger', 'Impossible d\'envoyer le mail');
            }
        }


        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
