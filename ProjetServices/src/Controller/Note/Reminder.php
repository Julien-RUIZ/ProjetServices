<?php

namespace App\Controller\Note;

use App\Interface\MailInterface;
use App\Repository\NoteRepository;
use App\Service\Mail\SendMail;
use Doctrine\ORM\EntityManagerInterface;
/**
 * Class used for email reminders of notes. It will be executed by order. The objective is to subsequently carry out a cron task.
 * Read : app/Command/ReminderNoteCommand.php
 */

class Reminder
{
    public function __construct(private NoteRepository $noteRepository, private MailInterface $mail, private EntityManagerInterface $entityManager)
    {
    }
    public function ReminderOn(){
        $notes = $this->noteRepository->findAll();
        foreach ($notes as $note){
           if($note->isReminder()===true){
               $dateForm = $note->getDate()->format('Y-m-d');
               $interval = $this->CmpDate($dateForm);

               $Emailsend = $this->DefaultMail($note);

                //if the interval between the reminder date and this day's date is null or '000' clear the reminder information and send the email
                if($interval === '000'){
                    $note->setReminder(false);
                    $note->setDate(null);
                    $note->setEmailsend(null);
                    $this->entityManager->persist($note);
                    $this->entityManager->flush();

                    // Sending the email
                    $this->mail->sendMail($Emailsend, $note->getUser()->getEmail(), $note->getTitle(), $note->getText());
                }
           }
        }
    }

    /**
     * @param $date
     * @return string
     * Comparison of two dates, the scheduled and the current date in order to know how many days remain.
     */
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


    /**
     * @param $note
     * If there is no email entered, use that of the user by default
     */
    public function DefaultMail($note){
        if (empty($note->getEmailsend())){
            $Emailsend = $note->getUser()->getEmail();
        }else{
            $Emailsend = $note->getEmailsend();
        }
        return $Emailsend;
    }
}