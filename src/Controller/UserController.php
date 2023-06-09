<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\User;
use App\Repository\AdressRepository;
use App\Repository\CakeLikeRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Namshi\JOSE\JWT;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\DateTime as ConstraintsDateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Json;

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

        $password = $data["password"];
        $email = $data["email"];
        $firstName = $data["firstName"];
        $lastName = $data["lastName"];
        $phone = $data["phone"];
        
        $address = $data['address'];
        $country = $data['country'];
        $postalCode = $data['postalCode'];
        $city = $data['city'];
        
        $user = $this->userRepo->findOneBy(["email" => $email]);
        if ($user instanceof User) {
            return new JsonResponse("L'utilisateur existe déjà", 400);
        }
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
    
        $email = $data["email"];
        $firstName = $data["firstName"];
        $lastName = $data["lastName"];
        $phone = $data["phone"];
        
        $adress1 = $data['address'];
        $country = $data['country'];
        $postalCode = $data['postalCode'];
        $city = $data['city'];
        
        $user = $this->userRepo->find($id);
       
        if(!$user instanceof User) return new JsonResponse("le client n'existe pas"); 
      
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPassword($user->getPassword());
        $user->setPhone($phone);

        $adress = $user->getAdress();

        $adress->setAdress1($adress1);
        $adress->setPostalCode($postalCode);
        $adress->setCity($city);
        $adress->setCountry($country);

        $user->setAdress($adress);
        


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

    // #[Route('/user/email', name: 'update_user', methods:['GET']) ] 
    // public function GetUserByMail($email): Response
    // {
    
    //     $user = $this->userRepo->getUserByMail($email);

    //     return $this->setReponse(200,'USER_UPDATE','USER UPDATE',$user,['get_user'],$this->serializer);
    // }


    // #[Route('/current/user', name: 'current_user', methods:['GET']) ] 
    // public function getCurrenUser(): Response
    // {
    
    //     $currentUser = $this->getUser();

    //     $data = $this->serializer->serialize($currentUser, "json", [
    //         'groups' => ['get_user']
    //     ]);

    //     return new Response($data, 200, [
    //         'Content-Type' => 'application/json'
    //     ]);
    // }

    #[Route('/current/user', name: 'current_user', methods:['GET']) ] 
    public function getCurrentUser()
    {
        $user = $this->getUser();

        $data = $this->serializer->serialize($user, "json", [
                    'groups' => ['get_user']
                ]);
        
                return new Response($data, 200, [
                    'Content-Type' => 'application/json'
                ]);

    }

    #[Route('/delete/user/{id}', name: 'delete_user', methods:['DELETE']) ] 
    public function deleteUser($id,CakeLikeRepository $likeRepo,CommentRepository $commentRepo)
    {
        $user = $this->userRepo->find($id);
       $likes = $user->getCakeLikes();
        foreach ($likes as  $like) {
            $liked = $likeRepo->find($like);
                 $user->removeCakeLike($liked);
            
              $this->em->persist($user);
              $this->em->flush();
     
          }

          $comments = $user->getComments();
       
     foreach ($comments as  $comment) {
        $commented = $commentRepo->find($comment);
        $user->removeComment($commented);
      
          $this->em->persist($user);
          $this->em->flush();
 
      }
        $this->em->remove($user);
        $this->em->flush();
        return new JsonResponse("L'utilisateur a été supprimé avec succès");

    }


    #[Route('/contact', name: 'contact', methods:['POST']) ] 
    public function contact(Request $request ,MailerInterface $mailer )
    {

        $data =  json_decode($request->getContent(), true);

        
        try {
            $emailUser =$data["email"];
            $lastName = $data["lastName"];
            $firstName = $data["firstName"];
            $phone = $data["phone"];
            $city = $data["city"];
            $content = $data["content"];
    
            $email = ( new TemplatedEmail())
            ->from($emailUser)
            ->to("contact.front-kick@gmail.com")
            ->subject('Contact')
            ->htmlTemplate('mails/comment.twig')
         
        ->context([
           "lastName" => $lastName,
           "firstName" => $firstName,
           "phone" => $phone,
           "city" => $city,
           "content" => $content,
        ]);
       
        $mailer->send($email);
       
        return $this->setReponse(200,'SEND_MAIL','MAILS SEND',$data,[],$this->serializer);
            //code...
        } catch (\Throwable $th) {
            return new JsonResponse ($th);
        }
     
    }

    #[Route('/forgot/password', name: 'reset_pâss', methods:['POST']) ] 
    public function ForgotPassword(Request $request,UserRepository $userRepo, EntityManagerInterface $em , MailerInterface $mailer ) 
    {
        $data = json_decode($request->getContent(),true);
        $emailUser = $data['email_user'];

        $user = $userRepo->findOneByEmail(['email' =>$emailUser]);

        if(!$user instanceof  User) return new JsonResponse("cet utilisateur n'existe pas",403);
         
        $user->setResetToken(sha1(uniqid()));
       
        $em->persist($user);

        $em->flush();

       $token = $user->getResetToken();
        // if($token) return new JsonResponse($token);
        $email = ( new TemplatedEmail())
        ->from('contact.front-kick@gmail.com')
        ->to($user->getEmail())
        ->subject("réinitialisation Mot De passe")
        ->htmlTemplate('mails/resetPassword.twig')
        ->context([
                    'reset_token'=>$user->getResetToken(),
                ]);    
       
    $mailer->send($email);
   
    return $this->setReponse(200,'SEND_MAIL','MAILS SEND',$token ,[],$this->serializer);

    }

    #[Route('/reset/password', name: 'reset_pass_form', methods:['POST']) ] 
    public function resetpassword( UserRepository $userRepo, Request $request,UserPasswordHasherInterface $encoder) 
    {

        $data = json_decode($request->getContent(),true);
        $password = $data['password']['password'];
        $confirmemail= $data['password']['confirmPassword'];
        $reset_token = $data['password']['reset_token'];

        if($confirmemail !== $password) throw new JsonResponse('les mots de passes doivent être identiques',403);
        $user = $this->userRepo->findOneBy(["resetToken" =>$data['password']['reset_token']]);

        if(!$user instanceof User) return new JsonResponse("cet utilisateur n'existe pas");
        $encoded = $encoder->hashPassword($user,$password);
        $user->setPassword($encoded);
        $user->setResetToken(null);
       
        $this->em->persist($user);

        $this->em->flush() ;

        return $this->setReponse(200,'PASSWORD MODIFY','PASSWORD MODIFY',$user->getLastName(),[],$this->serializer);

    }
}
