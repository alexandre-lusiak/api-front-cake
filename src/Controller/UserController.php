<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\User;
use App\Repository\AdressRepository;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\DateTime as ConstraintsDateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route("/api")]
class UserController extends ApiController
{
     private $validator;
     private $serializer;
     private $em;
     private $userRepo;
     private $addressRepo;
   

     public function __construct(AdressRepository $addressRepo,SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, UserRepository $userRepo)
     {
        $this->serializer = $serializer;
        $this->em = $em;
        $this->validator = $validator;
        $this->passwordEncorder = $validator;
        $this->userRepo = $userRepo;
        $this->addressRepo = $addressRepo;
     }

    #[Route('/users', name: 'get_users',methods:['GET'])] 
    public function getUsers()
    {
        $users = $this->userRepo->findAll();
        
        return $this->setReponse(200,'ALL_USERS','GET USERS',$users,['get_user','list_users'],$this->serializer);
    }

    #[Route('/register', name: 'add_user', methods:['POST'])]
    public function createUser( Request $request, UserPasswordHasherInterface $encoder)
    {
        $data = json_decode($request->getContent(), true);
        
        $password = $data['user']["password"];
        $email = $data['user']["email"];
        $firstName = $data['user']["firstName"];
        $lastName = $data['user']["lastName"];
        $phone = $data['user']["phone"];
        
        $address = $data['user']['address'];
        $country = $data['user']['country'];
        $postalCode = $data['user']['postalCode'];
        $city = $data['user']['city'];
       
        $adressUser = new Adress();

        $adressUser->setAdress1($address);
        $adressUser->setPostalCode($postalCode);
        $adressUser->setCity($city);
        $adressUser->setCountry($country);

        
        $user = new User();
        $user->setAdress($adressUser);
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPassword($lastName);
        $user->setRoles(["ROLE_USER"]);
        $user->setPhone($phone);
        $encoded = $encoder->hashPassword($user,$password);
        $user->setPassword($encoded);
        $user->setRegisteredAt(new DateTimeImmutable());

        $errors = $this->validator->validate($user);

        $errors->addAll($this->validator->validate($user));
        if(!$errors){
            return new JsonResponse("Vous ne pouvez pas accèder à cette requête", 200);
        }
        if($user) $errors->addAll($this->validator->validate($user));
        
        if (count($errors) > 0) return $this->setReponse(400, 'CREATE_CUSTOMER_FAILURE', 'La création a échoué', $errors);
       
        $this->em->persist($user);
        $this->em->flush();
        
        return $this->setReponse(200,'USER_CREATED','NEW USER CREATE',$user,['post_user'],$this->serializer);
      
    }


    #[Route('/user/{id}', name: 'update_user', methods:['PUT']) ] 
    public function updateUser($id,Request $request) {

        $data = json_decode($request->getContent(),true);
    
        $email = $data['user']["email"];
        $firstName = $data['user']["firstName"];
        $lastName = $data['user']["lastName"];
        $phone = $data['user']["phone"];
        
        $adress1 = $data['user']['address']['adress1'];
        $adress2 = $data['user']['address']['adress2'];
        $country = $data['user']['address']['country'];
        $postalCode = $data['user']['address']['postalCode'];
        $city = $data['user']['address']['city'];
        
        $user = $this->userRepo->find($id);
    
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPassword($lastName);
        $user->setPhone($phone);

    
        $adressUser = $this->addressRepo->find($data['user']['address']['id']);

        $adressUser->setAdress1($adress1);
        $adressUser->setAdress2($adress2);
        $adressUser->setPostalCode($postalCode);
        $adressUser->setCity($city);
        $adressUser->setCountry($country);

        $user->setAdress($adressUser);


        $errors = $this->validator->validate($user);

        $errors->addAll($this->validator->validate($user));
        if(!$errors){
            return new JsonResponse("Vous ne pouvez pas accèder à cette requête", 200);
        }
        if($user) $errors->addAll($this->validator->validate($user));
        
        if (count($errors) > 0) return $this->setReponse(400, 'CREATE_CUSTOMER_FAILURE', 'La création a échoué', $errors);
       
        $this->em->persist($user);
        $this->em->flush();
        
        return $this->setReponse(200,'USER_UPDATE','USER UPDATE',$user,['post_user'],$this->serializer);
      
    }

    #[Route('/user/email', name: 'update_user', methods:['GET']) ] 
    public function GetUserByMail($email): Response
    {
    
        $user = $this->userRepo->getUserByMail($email);

        return $this->setReponse(200,'USER_UPDATE','USER UPDATE',$user,['get_user'],$this->serializer);
    }

    
}
