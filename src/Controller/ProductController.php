<?php

namespace App\Controller;

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


    #[Route('/addcake', name: 'add_product',methods:['POST'])]
    public function createProduct( Request $request) : Response
    {

        $data = json_decode($request->getContent(),true);
       
        $product = new Product();

        $product->setName($data["cake"]["name"]);
        $product->setCreatedAt(new DateTimeImmutable());
        $product->setPriceHT(10);
        $product->setPriceTTC($data["cake"]['priceTTC']);
        $product->setTva(0,55);
        $product->setNbPerson($data["cake"]['nbPerson']);
        $product->setWeight($data["cake"]['weight']);

        $category = $this->catRepo->find($data["cake"]['category']);
        
        
        $product->setFile($data["cake"]["file"]);

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
    
    #[Route('/products/{id}', name: 'update_product', methods:['PUT'])]
    public function updateProduct($id,Request $request)
    {
        $data = json_decode($request->getContent(),true);
        $product = $this->productRepo->find($id);
        if(!$product instanceof Product) return new JsonResponse('VA niké ta mere');
        $product->setName($data["name"]);
        $product->setCreatedAt(new DateTimeImmutable());
        $product->setPriceHT($data['priceHT']);
        $product->setPriceTTC($data['priceTTC']);
        $product->setTva($data['tva']);
        $product->setNbPerson($data['nbPerson']);
        $product->setWeight($data['weight']);

        $category = $this->catRepo->find($data['category']['id']);
        
        
        $product->setCategory($category);
        $errors = $this->validator->validate($product);
        $errors->addAll($this->validator->validate($product));
        if(!$errors){
            return new JsonResponse("Vous ne pouvez pas accèder à cette requête", 200);
        }
        if($product) $errors->addAll($this->validator->validate($product));
        dd($errors);
       
        if (count($errors) > 0) return $this->setReponse(400, 'UPDATE_PRODUCT_FAILURE', 'La création du produit a  échoué', $errors);
       
        $this->em->persist($product);
        $this->em->flush();

        return $this->setReponse('200','POST Products ','POST USER SUCESS',$product,['post_product'],$this->serializer);
        
    }
}
