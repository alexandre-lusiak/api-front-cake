<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Mailer\MailerInterface;
#[Route("/api")]
class CommentController extends ApiController
{
    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' =>  'CommentController',
        ]);
       }



       #[Route('/comment/send', name: 'send_comment',methods:['POST'])]
    public function SendComment(Request $request ,UserRepository $userRepo, EntityManagerInterface $em , SerializerInterface $serializer,MailerInterface $mailer) : Response
    {

        $data = json_decode( $request->getContent() ,true);

        $comment = new Comment();

        $email = $data["comment"]['email'];
        
        $content = $data["comment"]['content'];
        
        $pesudo = $data["comment"]['pseudo'];

        $user = $userRepo->find(2);
        $comment->setUser($user);
        $comment->setContent($content);
        $comment->setPseudo($pesudo);
        $comment->setCreatedAt(new DateTimeImmutable('now'));

        $em->persist($comment);
       $em->flush();

       try {
           $email = (new TemplatedEmail())
           ->from($email)
           ->to("alexandre.lusiak@gmail.com")
           ->subject('Commentaire')
           ->htmlTemplate('mails/comment.twig')
           
       
   
       ->context([
           $comment
       ]);
       $mailer->send($email);
       } catch (\Throwable $th) {
          
       }

   dd($email);

        return $this->setReponse('200','POST comment ','POST comment SUCESS',$comment,["post_comment"],$serializer);

    }
}
