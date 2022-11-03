<?php

namespace App\Controller;

use App\Repository\CakeLikeRepository;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route('/api')]
class StatsController extends ApiController
{
    private $likeRepo;
    private $userRepo;
    private $commentRepo;
    private $productRepo;
    private $validator;
    private $serializer;
    private $em;

    public function __construct(
        CakeLikeRepository $likeRepo ,
        SerializerInterface $serializer,
        EntityManagerInterface $em, 
        ValidatorInterface $validator,
        ProductRepository $productRepo, 
        UserRepository $userRepo,
        CommentRepository $commentRepo )
        {
            $this->validator = $validator;
            $this->serializer = $serializer;
            $this->em = $em;
            $this->productRepo = $productRepo;
            $this->likeRepo=$likeRepo;
            $this->userRepo=$userRepo;
            $this->commentRepo=$commentRepo;
           
        }

    #[Route('/stats', name: 'app_stats',methods:['GET'])]
    public function index(): Response
    {

        $comments = $this->commentRepo->findAll();

        $countComment = count($comments);

        $products = $this->productRepo->findAll();
        $countProduct = count($products);

        $likes = $this->likeRepo->findAll();
        $countLike = count($likes);

        $users = $this->userRepo->findAll();
        $countUser = count($users);

        $stats = [
         'com' => $countComment,
         'prod' => $countProduct,
         'like' => $countLike,
         'User' => $countUser
        ];
            
        return $this->setReponse('200','GET ALL Products','GET products  SUCESS',$stats,[],$this->serializer);
        }

}
