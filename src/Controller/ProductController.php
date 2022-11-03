<?php

namespace App\Controller;

use App\Entity\CakeLike;
use App\Entity\File;
use App\Entity\Product;
use App\Repository\CakeLikeRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\FileRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class ProductController extends ApiController
{

     private $validator;
     private $serializer;
     private $em;
     private $productRepo;
     private $catRepo;

     public function __construct(CategoryRepository $catRepo ,SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, ProductRepository $productRepo){

        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->em = $em;
        $this->productRepo = $productRepo;
        $this->catRepo=$catRepo;
     }




    #[Route('/cakes', name: 'app_product',methods:['GET'])]
    public function getProducts() 
    {

        $products = $this->productRepo->findAll();

        return $this->setReponse('200','GET ALL Products','GET products  SUCESS',$products,["get_products"],$this->serializer);
    }

    #[Route('/cake/{id}', name: 'get_product',methods:['GET'])]
    public function getProductById($id) 
    {

        $product = $this->productRepo->find($id);
        if(!$product instanceof Product) return new JsonResponse("Le produit n'existe pas");

        return $this->setReponse('200','GET Product','GET product SUCESS',$product,["get_products"],$this->serializer);
    }


    #[Route('/addcake', name: 'add_product',methods:['POST'])]
    public function createProduct( Request $request,FileRepository $fileRepo) : Response
    {

        $data = json_decode($request->getContent(),true);
     
        $product = new Product();
        
        $file = $fileRepo->find($data['file']); 

        if(!$file instanceof File) return new JsonResponse("Erreur l'image nexiste pas");
       
        $product->setFile($file);
        $product->setName($data["name"]);
        $product->setCreatedAt(new DateTimeImmutable());
        $product->setPriceHT(10);
        $product->setPriceTTC($data['priceTTC']);
        $product->setTva(0,55);
        $product->setNbPerson($data['nbPerson']);
        $product->setWeight($data['weight']);
        $product->setIsActif($data['isActif']);

        $category = $this->catRepo->find($data['category']);
        
        $product->setCategory($category);

        $errors = $this->validator->validate($product);

        $errors->addAll($this->validator->validate($product));
        if(!$errors){
            return new JsonResponse("Vous ne pouvez pas accèder à cette requête", 200);
        }
        if($product) $errors->addAll($this->validator->validate($product));
        
        if (count($errors) > 0) return $this->setReponse(400, 'CREATE_PRODUCT_FAILURE', 'La création du produit a  échoué', $errors);
       
        $this->em->persist($product);
        $this->em->flush();


        return $this->setReponse('200','POST Products ','POST USER SUCESS',$product,['post_product'],$this->serializer);
    }
    
    #[Route('/updateCake/{id}', name: 'update_product', methods:['PUT'])]
    public function updateProduct($id,Request $request,FileRepository $fileRepo)
    {
        $data = json_decode($request->getContent(),true);
        $product = $this->productRepo->find($id);
        if(!$product instanceof Product) return new JsonResponse("le produit n'existe pas");
        $product->setName($data["name"]);
        // $product->setPriceHT($data['priceHT']);
        $product->setPriceTTC($data['priceTTC']);
        // $product->setTva($data['tva']);
        $product->setNbPerson($data['nbPerson']);
        $product->setWeight($data['weight']);
        $product->setIsActif($data['isActif']);

        $category = $this->catRepo->find($data['category']);
        $file = $fileRepo->find($data['file']); 

        if(!$file instanceof File) return new JsonResponse("Erreur l'image nexiste pas");
       
        $product->setFile($file);
        
        $product->setCategory($category);
        $errors = $this->validator->validate($product);
        $errors->addAll($this->validator->validate($product));
        if(!$errors){
            return new JsonResponse("Vous ne pouvez pas accèder à cette requête", 200);
        }
        if($product) $errors->addAll($this->validator->validate($product));
       
        if (count($errors) > 0) return $this->setReponse(400, 'UPDATE_PRODUCT_FAILURE', 'La création du produit a  échoué', $errors);
       
        $this->em->persist($product);
        $this->em->flush();

        return $this->setReponse('200','PUT Products ','Put cake SUCESS',$product,['post_product'],$this->serializer);
        
    }


    #[Route('/cake/upload/', name: 'upload_product',methods:['POST'])]
    public function uploadFile($id,Request $request) 
    {
        $data = $request->getContent();
        $file = new File($data);

        $product = $this->productRepo->find($id);
        if(!$product instanceof Product) return new JsonResponse("Le produit n'existe pas");
        $product->setFile($file);
        return $this->setReponse('200', 'GET  Product','GET product  SUCESS',$product,["get_products"],$this->serializer);
    }


    #[Route('/delete/cake/{id}', name: 'delete_product',methods:['DELETE'])]
    public function deleteCake($id, CakeLikeRepository $likeRepo, CommentRepository $commentRepo) 
    {
        $product = $this->productRepo->find($id);
        if(!$product instanceof Product) return new JsonResponse("product n'existe pas");
     $likes =   $product->getCakeLikes();
     $comments = $product->getComments();
       
     foreach ($comments as  $comment) {
        $commented = $commentRepo->find($comment);
             $product->removeComment($commented);
      
          $this->em->persist($product);
          $this->em->flush();
 
      }

     foreach ($likes as  $like) {
       $liked = $likeRepo->find($like);
            $product->removeCakeLike($liked);
     
         $this->em->persist($product);
         $this->em->flush();

     }
        $this->em->remove($product);
        $this->em->flush();

        return $this->setReponse('200','delete  Product','Delete product  SUCESS',$product,["get_products"],$this->serializer);
    }

    #[Route('/user/like/{id}', name: 'like_product',methods:['POST'])]
    public function like($id,ProductRepository $productRepo, CakeLikeRepository $likeRepo , EntityManagerInterface $em, Request $request, UserRepository $userRepo, ) :Response
    {
       $data = json_decode($request->getContent(),true);
      
            /*****************************/ 
            /* on recupere l'utilisateur */
            /*****************************/       
        $user= $userRepo->find($data['id_user']);
            /*******************************************/ 
            /* logic to see if the user is logged in   */ 
            /* and if he has already liked the article */
            /*******************************************/
            $product =  $productRepo->find($id);
            /* if the user is not logged in*/    
        // if(!$user) {
        //     return $this->json([
        //         'code'=>403,
        //         'message'=> "Vous devez etre connecté"
        //         ],403);
        // }
            /* case where the article is already likedé*/
        
          
        if($product->likedByUser($user)) {
            $like =$likeRepo->findOneBy([
                'product'=>$product,
                'user'=>$user
                ]); 
            $countLike =count($like->getProduct()->getCakeLikes());
            $em->remove($like);
            $em->flush();
            
            return $this->setReponse('200','delete like','delete like sucess',$countLike,["get_products","get_like"],$this->serializer);
        }
             /* case where the user has not yet like*/
        else {
            $like = new CakeLike();
            $like->setProduct($product);
            $like->setUser($user);
            $em->persist($like);
            $em->flush();
            $countLike =count($like->getProduct()->getCakeLikes());
        
            return $this->setReponse('200','add like','add like sucess',$countLike,["get_products","get_like"],$this->serializer);
        }

        
        
    }                        


}
