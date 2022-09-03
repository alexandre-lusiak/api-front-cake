<?php

namespace App\Controller;

use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{

    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

   public function setReponse(int $code,string $name, string $message ,$data =null , array $groups = [], $serializer = null) 
   {
        if($data && $serializer) {
            $response = $serializer->serialize([
                'code' => $code,
                'name' => $name,
                'message' => $message,
                'data' => $data
            ],'json',[
                'groups' => $groups
            ]);
        }else if($serializer){
            $response = $serializer->serialize([
                'code' => $code,
                'name' => $name,
                'message' => $message,
                'data' => $message
            ], "json");
        } else if ($data){
            return $this->json([
                'code' => $code,
                'name' => $name,
                'message' => $message,
                'data' => $data
            ],$code);
        }else {
            return new JsonResponse([
                'code' => $code,
                'name' => $name,
                'message' => $message,
                'data' => $message
            ], 200);
        }
        return new Response($response, $code, [
            'Content-Type' => 'application/json'
        ]);
   }

   public function setResponseWithOutSerializer(int $code, string $name, string $message, $data = null)
   {
       if($data) {
           return new JsonResponse([
               'code' => $code,
               'name' => $name,
               'message' => $message,
               'data' => $data
           ], $code);
       } else {
           return new JsonResponse([
               'code' => $code,
               'name' => $name,
               'message' => $message,
               'data' => $message
           ], $code);
       }

   }

   public function setData($data, $object)
   {
       foreach ($data as $key => $value) {
           if ($key) {
               $name = str_replace('_', ' ', $key);
               $name = ucwords(strtolower($name));
               $name = str_replace(' ', '', $name);
               try {
                   $setter = 'set' . $name;
                   $object->$setter($value);
               } catch(Error $e) {
               }

           }
       }
       return $object;
   }

}
