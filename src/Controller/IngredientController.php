<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class IngredientController extends ApiController
{
    #[Route('/ingredients', name: 'app_ingredients',methods:['GET'])]
    public function GetReceiptDay(IngredientRepository $ingrRepo, SerializerInterface $serializer): Response
    {

        $ingredients = $ingrRepo->findAll();
        return $this->setReponse('200','GET  Receipt','GET receipt  SUCESS',$ingredients,["get_receipt"],$serializer);
        
    }

    #[Route('/ingredient/{id}', name: 'update_ingredient',methods:['PUT'])]
    public function updataReceiptDay($id,Request $request, SerializerInterface $serializer, IngredientRepository $ingreRepo, EntityManagerInterface $em): Response
    {

        $data = json_decode($request->getContent(),true);

        $ingredient = $ingreRepo->find($id);
        if(!$ingredient instanceof Ingredient) return new JsonResponse("l'ingredient n'existe pas");
        $ingredient->setName(  $data['name']);
     
        $em->persist($ingredient);
        $em->flush();

        return $this->setReponse('200','Update  ingredient','Update ingredient  SUCESS',$ingredient,["get_ingredient"],$serializer);
        
    }


    #[Route('/ingredient/create', name: 'add_ingredient',methods:['POST'])]
    public function create(Request $request, SerializerInterface $serializer, IngredientRepository $ingreRepo, EntityManagerInterface $em): Response
    {

        $data = json_decode($request->getContent(),true);

        $ingredient = new Ingredient();

        $ingredient->setName(  $data['name']);
     
        $em->persist($ingredient);
        $em->flush();

        return $this->setReponse('200','add  ingredient','add ingredient  SUCESS',$ingredient,["get_ingredient"],$serializer);
        
    }


    #[Route('/delete/ingredient/{id}', name: 'delete_ingredient',methods:['DELETE'])]
    public function deleteCake($id,EntityManagerInterface $em,IngredientRepository $ingreRepo , SerializerInterface $serializer) 
    {
        $ingredient =$ingreRepo->find($id);
        if(!$ingredient instanceof Ingredient) return new JsonResponse("l'ingredient n'existe pas");
        $em->remove($ingredient);
        $em->flush();

        return $this->setReponse('200','delete  ingredient','Delete ingredient  SUCESS',$ingredient,["get_ingredient"],$serializer);
    }

}
