<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController {
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
      $this->entityManager = $entityManager;
    }
    
    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response {

        $notification = null;
      $user = new User();
      $form = $this->createForm(RegisterType::class, $user);
      
      $form->handleRequest($request);
      
      if($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();

        $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

        if(!$search_email){
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $mail = new Mail();
            $content = "Bonjour ". $user->getFirstname(). "<br/>Bienvenue sur la première boutique dédiée au made in France.<br><br/>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
            $mail->send($user->getEmail(),$user->getFirstname(), 'Bienvenue sur la Boutique Française', $content);

            $notification= "Votre inscription s'est correctement déroulé. Vous pouvez dès à présent vous connecter à votre compte.";
        } else{
            $notification= "L'email que vous avez renseigné existe déjà";
        }



      }
      
      return $this->render('register/index.html.twig', [
          'form' => $form->createView(),
          'notification' => $notification
      ]);
    }
}
