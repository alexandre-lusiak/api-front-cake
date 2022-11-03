<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Mailer\MailerInterface;
#[Route("/api")]
class CommentController extends ApiController
{




       #[Route('/comment/user/{id}', name: 'comment',methods:['POST'])]
    public function SendComment($id,Request $request ,UserRepository $userRepo, ProductRepository $productRepo, EntityManagerInterface $em , SerializerInterface $serializer) : Response
    {

        $data = json_decode( $request->getContent() ,true);

        $comment = new Comment();

        $content = $data['content'];
        
        $idCake = $data["id"];
        $product = $productRepo->find($idCake);
        if(!$product instanceof Product) return new JsonResponse("ce produit n'existe pas");
        $user = $userRepo->find( $id );
        if(!$user instanceof User) return new JsonResponse("cet utilisateur n'existe pas");
        $comment->setUser($user);
        $comment->setProduct($product);
        $comment->setContent($content);
        $comment->setCreatedAt(new DateTimeImmutable('now'));

        $em->persist($comment);
        $em->flush();

        return $this->setReponse('200','POST comment ','POST comment SUCESS',$comment,["post_comment"],$serializer);

    }


    #[Route('/comment/cake/{id}', name: 'get_comment')]
    public function getCommentByProduct($id,ProductRepository $productRepo,SerializerInterface $serializer) 
    {

        $product = $productRepo->find($id);
      $comment =  $product->getComments();

        return $this->setReponse('200','GET ALL Category','GET Categories  SUCESS',$comment,["get_comment"],$serializer);
    }


    #[Route('/comment', name: 'get_comments',methods:['GET'])]
    public function getComments(CommentRepository $commentRepo,SerializerInterface $serializer) 
    {

        $comments = $commentRepo->findAll();
      
        return $this->setReponse('200','GET ALL Category','GET Categories  SUCESS',$comments,["get_comment"],$serializer);
    }

    #[Route('/comment/{id}', name: 'get_comment_i' , methods:['GET'])]
    public function getCommentId($id,CommentRepository $commentRepo,SerializerInterface $serializer) 
    {

      $comment =  $commentRepo->find($id);
    if(!$comment instanceof Comment ) return new JsonResponse("Ce commentaire n'existe pas") ;

        return $this->setReponse('200','GET ALL Category','GET Categories  SUCESS',$comment,["get_comment"],$serializer);
    }

    
    #[Route('/comment/delete/{id}', name: 'detele_comment', methods:['DELETE'])]
    public function deleteComment($id,CommentRepository $commentRepo,SerializerInterface $serializer,EntityManagerInterface $em) 
    {

      $comment =  $commentRepo->find($id);
    if(!$comment instanceof Comment ) return new JsonResponse("Ce commentaire n'existe pas",401) ;
        $em->remove($comment);
        $em->flush();

        return $this->setReponse('200','DELETE COMMENT','DELETE comment  SUCESS',$comment,["get_comment"],$serializer);
    }
}
