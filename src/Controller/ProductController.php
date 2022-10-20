<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
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
    public function createProduct( Request $request) : Response
    {

        $data = json_decode($request->getContent(),true);
       
        $product = new Product();

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
    public function updateProduct($id,Request $request)
    {
        $data = json_decode($request->getContent(),true);
        $product = $this->productRepo->find($id);
        if(!$product instanceof Product) return new JsonResponse('VA niké ta mere');
        $product->setName($data["name"]);
        // $product->setPriceHT($data['priceHT']);
        $product->setPriceTTC($data['priceTTC']);
        // $product->setTva($data['tva']);
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
       
        if (count($errors) > 0) return $this->setReponse(400, 'UPDATE_PRODUCT_FAILURE', 'La création du produit a  échoué', $errors);
       
        $this->em->persist($product);
        $this->em->flush();

        return $this->setReponse('200','PUT Products ','Put cake SUCESS',$product,['post_product'],$this->serializer);
        
    }


    #[Route('/cake/upload/{id}', name: 'upload_product',methods:['GET'])]
    public function uploadFile($id,Request $request) 
    {
        $data = $request->getContent();
        $file = new File($data);

        $product = $this->productRepo->find($id);
        if(!$product instanceof Product) return new JsonResponse("Le produit n'existe pas");
        $product->setFile($file);
        return $this->setReponse('200','GET  Product','GET product  SUCESS',$product,["get_products"],$this->serializer);
    }


    #[Route('/delete/cake/{id}', name: 'delete_product',methods:['DELETE'])]
    public function deleteCake($id) 
    {
        $product = $this->productRepo->find($id);
        if(!$product instanceof Product) return new JsonResponse("product n'existe pas");
        
        $this->em->remove($product);
        $this->em->flush();

        return $this->setReponse('200','delete  Product','Delete product  SUCESS',$product,["get_products"],$this->serializer);
    }


}
