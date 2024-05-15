<?php

namespace App\Controller\Note;

use App\Repository\NoteRepository;
use App\Service\SendMail;
use Doctrine\ORM\EntityManagerInterface;

class Reminder
{
    public function __construct(private NoteRepository $noteRepository, private SendMail $sendMail, private EntityManagerInterface $entityManager)
    {
    }
    public function ReminderOn(){
        $notes = $this->noteRepository->findAll();
        foreach ($notes as $note){
           if($note->isReminder()===true){
               $dateForm = $note->getDate()->format('Y-m-d');
               $interval = $this->CmpDate($dateForm);

               if (empty($note->getEmailsend())){
                   $Emailsend = $note->getUser()->getEmail();
               }else{
                   $Emailsend = $note->getEmailsend();
               }

                if($interval === '000'){
                    $note->setReminder(false);
                    $note->setDate(null);
                    $note->setEmailsend(null);
                    $this->entityManager->persist($note);
                    $this->entityManager->flush();
                    $this->sendMail->sendMail($Emailsend, $note->getUser()->getEmail(), $note->getTitle(), $note->getText());
                }
           }
        }
    }
    private function CmpDate($date){
        date_default_timezone_set('Europe/Paris');
        $dt = date('Y-m-d');
        $origin = date_create($dt);
        $target = date_create($date);
        $interval = date_diff($origin, $target);
        return $interval->format('%y%m%d');
    }

    public function CurrentDate (){
        date_default_timezone_set('Europe/Paris');
        return new \DateTime();
    }
}