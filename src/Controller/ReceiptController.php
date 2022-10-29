<?php

namespace App\Controller;

use App\Entity\Receipt;
use App\Repository\IngredientRepository;
use App\Repository\ReceiptRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
#[Route('/api')]
class ReceiptController extends ApiController
{
    

    #[Route('/receipt', name: 'app_receipt',methods:['GET'])]
    public function GetReceiptDay(ReceiptRepository $receiptRepo, SerializerInterface $serializer): Response
    {

        $receipt = $receiptRepo->findAll();
        return $this->setReponse('200','GET  Receipt','GET receipt  SUCESS',$receipt,["get_receipt"],$serializer);
        
    }


    #[Route('/receipt/{id}', name: 'update_receipt',methods:['PUT'])]
    public function updataReceiptDay($id,Request $request,ReceiptRepository $receiptRepo, SerializerInterface $serializer, IngredientRepository $ingreRepo, EntityManagerInterface $em): Response
    {

        $data = json_decode($request->getContent(),true);

        $receipt = $receiptRepo->find($id);
        if(!$receipt instanceof Receipt) return new JsonResponse("la recette n'existe pas");
        $receipt->setTitle(  $data['title']);
        $receipt->setDescription( $data['description']);
        $receipt->setIsActif( $data['isActif']);
        foreach($data['ingredients'] as $ingredient){
            $ingre = $ingreRepo->find($ingredient);
            $receipt->addIngredient($ingre);
        }

        $em->persist($receipt);
        $em->flush();

        return $this->setReponse('200','Update  Receipt','Update receiptDay  SUCESS',$receipt,["get_receipt"],$serializer);
        
    }


    #[Route('/receipt/create', name: 'add_receipt',methods:['POST'])]
    public function create(Request $request,ReceiptRepository $receiptRepo, SerializerInterface $serializer, IngredientRepository $ingreRepo, EntityManagerInterface $em): Response
    {

        $data = json_decode($request->getContent(),true);

        $receipt = new Receipt();

        $receipt->setDescription($data['description']);
        $receipt->setTitle($data['title']);
        $receipt->setIsActif( $data['isActif']);
        foreach($data['ingredients'] as $ingredient){
            $ingre = $ingreRepo->find($ingredient);
            $receipt->addIngredient($ingre);
        }

        $em->persist($receipt);
        $em->flush();

        return $this->setReponse('200','add  Receipt','add receiptDay  SUCESS',$receipt,["post_receipt"],$serializer);
        
    }


    #[Route('/delete/receipt/{id}', name: 'delete_Receipt',methods:['DELETE'])]
    public function deleteCake($id,EntityManagerInterface $em) 
    {
        $receipt = $this->catRepo->find($id);
        if(!$receipt instanceof Receipt) return new JsonResponse("la recette n'existe pas");
        $em->remove($receipt);
        $em->flush();

        return $this->setReponse('200','delete  Receipt','Delete Receipt  SUCESS',$receipt,["get_receipt"],$this->serializer);
    }


}
