<?php


namespace App\Domain\Tools;


class Mailer
{

    private $mailer;

    const SENDER_EMAIL_ADRESS = 'rouaults11@gmail.com';

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer= $mailer;
    }

    public function sendMail(string $emailAddress, string $messageSubject, string $messageBody){

       $message = (new \Swift_Message($messageSubject))
           ->setFrom(self::SENDER_EMAIL_ADRESS)
           ->setTo($emailAddress)
           ->setBody($messageBody, 'text/html');

       return $this->mailer->send($message);

    }

}