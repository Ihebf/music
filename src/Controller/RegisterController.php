<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{

    private $entityManager;
    // Construction pour initialiser la variable entityManager
    public function __construct(EntityManagerInterface $entityManager ){
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request , UserPasswordHasherInterface $encoder ): Response
    {

        $notification = null;

        //crée un objet user.
        $user = new User();
        // création d'un formulaire pour user
        $form = $this->createForm(RegisterType::class, $user);
        // Pour traiter les données du formulaire
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            //$form->getData() contient les valeurs soumises
            // la variable $user d'origine a également été mise à jour
            $user = $form->getData();
            // vérifier si l'e-mail existe dans la base de données ou non
            $user_find = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());
            // si l'e-mail n'existe pas dans la base de données
            if (!$user_find){
                // hasher le mdp
                $password = $encoder->hashPassword($user ,$user ->getPassword());
                $user ->setPassword($password);
                // Insérer l'utilisateur dans la base de données
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = "Votre inscription s'est bien déroulée";
            }else{ // si l'e-mail existe
                $notification = "L'email utilisé existe déja";
            }
        }
        // Cette méthode s'exécute lors de l'utilisation de l'url localhost/inscription
        // Il affichera l'interface développée dans le fichier register/index.html.twig
        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
