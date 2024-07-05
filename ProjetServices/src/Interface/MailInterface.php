<?php

namespace App\Interface;

interface MailInterface
{
    public function sendMail($mailForm, $userMail, $titre, $text );
}