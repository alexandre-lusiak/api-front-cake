<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
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
class CategoryController extends ApiController
{

    private $validator;
    private $serializer;
    private $em;
    private $catRepo;
   
    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, CategoryRepository $catRepo){

       $this->validator = $validator;
       $this->serializer = $serializer;
       $this->em = $em;
       $this->catRepo = $catRepo;
    }

    
    #[Route('/addCategory', name: 'add_category',methods:['POST'])]
    public function createCategory( Request $request): Response
    {
        $data = json_decode($request->getContent(),true);
        
        $category = new Category();

        $category->setName($data["name"]);
        $category->setDescription($data['description']);
       
    
        $errors = $this->validator->validate($category);

        $errors->addAll($this->validator->validate($category));
        if(!$errors){
            return new JsonResponse("Vous ne pouvez pas accèder à cette requête", 200);
        }
        if($category) $errors->addAll($this->validator->validate($category));
        
        if (count($errors) > 0) return $this->setReponse(400, 'CREATE_category_FAILURE', 'La création du produit a  échoué', $errors);
       
        $this->em->persist($category);
        $this->em->flush();


        return $this->setReponse('200','POST category ','POST CAtegorY SUCESS',$category,["post_category"],$this->serializer);
    }


    #[Route('/categories', name: 'app_categories')]
    public function getCategories() 
    {

        $categories = $this->catRepo->findAll();

        return $this->setReponse('200','GET ALL Category','GET Categories  SUCESS',$categories,["get_category"],$this->serializer);
    }


    #[Route('/updateCategory/{id}', name: 'update_category',methods:['PUT'])]
    public function updateCategory($id, Request $request): Response
    {
        $data = json_decode($request->getContent(),true);
        
        $category = $this->catRepo->find($id);

        if(!$category instanceof Category) return new JsonResponse("Cette category n'exxiste pas");

        $category->setName($data["name"]);
        $category->setDescription($data['description']);
       
    
        $errors = $this->validator->validate($category);

        $errors->addAll($this->validator->validate($category));
        if(!$errors){
            return new JsonResponse("Vous ne pouvez pas accèder à cette requête", 200);
        }
        if($category) $errors->addAll($this->validator->validate($category));
        
        if (count($errors) > 0) return $this->setReponse(400, 'Update_category_FAILURE', 'La création de ccategory a  échoué', $errors);
       
        $this->em->persist($category);
        $this->em->flush();


        return $this->setReponse('200','PUT category ','PUT CAtegorY SUCESS',$category,["post_category"],$this->serializer);
    }


    #[Route('/delete/category/{id}', name: 'delete_category',methods:['DELETE'])]
    public function deleteCake($id) 
    {
        $category = $this->catRepo->find($id);
        $CategoryWait = $this->catRepo->find(5);
        if(!$category instanceof Category) return new JsonResponse("category n'existe pas");

      $products =  $category->getProduct();
      if($products !== []){

          foreach ($products as  $product) {
              $product->setCategory($CategoryWait);
              $this->em->persist($product);
          }
          $this->em->flush();
      }
        $this->em->remove($category);
        $this->em->flush();

        return $this->setReponse('200','delete  Category','Delete category  SUCESS',$category,["get_category"],$this->serializer);
    }

}
