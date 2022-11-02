<?php

namespace App\Controller;

use App\Entity\File;
use App\Repository\FileRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/api')]
class FileController extends ApiController
{



    #[Route('/file', name: 'app_file')]
    public function index(FileRepository $fileRepo , $id): Response
    {   
        $file  = $fileRepo->find($id);

        return $this->setReponse(200,'USER_CREATED','NEW USER CREATE',$file,['get_file'],$this->serializer);
        
      
    }

    #[Route('/upload/file/', name: 'add_file' , methods:['POST']) ]
    public function uploadFile( Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ProductRepository $productRepo,SluggerInterface $slugger): Response
    {
        
        // $data = json_decode($request->getContent(),true);
     
        $file = new File();
      
        $brochureFile = $request->files->get('file');
            
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
    
                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('files_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
    
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $file->setFilePath($newFilename);
                $file->setCaption($request->get("caption"));
            }
       
        //     $file = new File();
        //     //code...
        //     $uploadedFile = $request->attributes->get('selectedFile');
        //     $extension = $uploadedFile->guessExtension();
        
        //    $name =  md5(uniqid());
        //    $fileName = $name.'.'.$extension;
        //    $uploadedFile->move($this->getParameter('files_directory'), $fileName);
        //    $file->setFilePath($fileName);
        //    $file->setCaption($request->get("caption"));
               
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
