<?php


namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class Mails
{

    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(Environment $twig, MailerInterface $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function createEmailComment(string $template, array $data = []): Email
    {
        $this->twig->addGlobal('format', 'html');
        $html = $this->twig->render($template, array_merge($data, ['layout' => 'mails/base.html.twig']));
        return (new Email())
            ->from('front-cake@gmail.com')
            ->html($html);
    }

    
    public function createEmailContact(string $template, array $data = [], string $email): Email
    {
        $this->twig->addGlobal('format', 'html');
        $html = $this->twig->render($template, array_merge($data, ['layout' => 'mails/base.html.twig']));
        return (new Email())
        ->from($email)
        ->subject('CLIMPROPRE | Prise de contact')
        ->to('Contact@climpropreapps.fr')
        ->html($html);
        
    }
    
    
    public function send(Email $email): void
    {
        $this->mailer->send($email);
    }
}