<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\User;
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
   

     public function __construct(SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, UserRepository $userRepo)
     {
        $this->serializer = $serializer;
        $this->em = $em;
        $this->validator = $validator;
        $this->passwordEncorder = $validator;
        $this->userRepo = $userRepo;
     }

    #[Route('/users', name: 'get_user')] 
    public function getUsers()
    {
        $users = $this->userRepo->findAll();
        
        return $this->setReponse(200,'ALL_USERS','GET USERS',$users,['get_user','list_user'],$this->serializer);
    }

    #[Route('/register', name: 'app_user')]
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
        
        return $this->setReponse(200,'USER_CREATED','NEW USER CREATE',$user,['get_user','list_user'],$this->serializer);
      
    }

    
}
