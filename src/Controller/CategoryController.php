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

    
    #[Route('/category', name: 'add_category')]
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


        return $this->setReponse('200','POST category ','POST USER SUCESS',$category,["post_category"],$this->serializer);
    }


}
