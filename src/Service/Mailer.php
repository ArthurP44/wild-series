<?php


namespace App\Service;


use App\Entity\Program;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class Mailer
{
    private $mailer;
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(MailerInterface $mailer, Environment $environment)
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
    }

    public function sendProgramNotification(Program $program)
    {
        $email = (new TemplatedEmail())
            ->from($_ENV['MAILER_FROM'])
            ->to($_ENV['MAILER_TO'])
            ->subject('Une nouvelle série vient d\'être publiée magueule !')
            ->htmlTemplate('program/notifications/new_program.html.twig')
            ->context([
                'program' => $program,
            ])
            ;

        $this->mailer->send($email);
    }

}