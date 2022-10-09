<?php

namespace App\Controller;

use App\Entity\File;
use App\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class FileController extends ApiController
{



    #[Route('/file', name: 'app_file')]
    public function index(FileRepository $fileRepo , $id): Response
    {   
        $file  = $fileRepo->find($id);

        return $this->setReponse(200,'USER_CREATED','NEW USER CREATE',$file,['get_file'],$this->serializer);
        
      
    }

    #[Route('/upload/file', name: 'add_file' , methods:['POST']) ]
    public function uploadFile( Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        
        
   
            $file = new File();
            //code...
            $uploadedFile = $request->files->get('file');
            
            $extension = $uploadedFile->guessExtension();
    
           $name =  md5(uniqid());
           $fileName = $name.'.'.$extension;
           $uploadedFile->move($this->getParameter('files_directory'), $fileName);
           $file->setFilePath($fileName);
           $file->setCaption($request->get("caption"));
    
           $entityManager->persist($file);
           $entityManager->flush();
    
           $data = $serializer->serialize($file, "json", [
                'groups' => ['get_file']
            ]);
    
            return new Response($data, 201, [
                'Content-Type' => 'application/json'
            ]);
       

    }

    
    // public function uploadFileBase64(Request $request, Base64FileExtractor $base64FileExtractor, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    // {
    //     $data = json_decode($request->getContent(), true);
    //     $base64Image =$data['base64Image'];
    //     $base64Image = $base64FileExtractor->extractBase64String($base64Image);
    //     $imageFile = new UploadedBase64File($base64Image, "signature");
    //     $file = new File();

    //     $extension = $imageFile->guessExtension();

    //    $name =  md5(uniqid());
    //    $fileName = $name .'.'.$extension;
    //    $imageFile->move($this->getParameter('files_directory'), $fileName);
    //    $file->setFilePath($fileName);
    //    $file->setCaption($request->get("caption"));


    //    $entityManager->persist($file);
    //    $entityManager->flush();

    //    $data = $serializer->serialize($file, "json", [
    //         'groups' => ['get_file']
    //     ]);

    //     return new Response($data, 201, [
    //         'Content-Type' => 'application/json'
    //     ]);
    // }
}
