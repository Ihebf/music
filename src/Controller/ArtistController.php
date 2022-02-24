<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistController extends AbstractController
{
    // Cette méthode s'exécute lors de l'utilisation de l'url localhost/artist
    // Il affichera l'interface développée dans le fichier artist/index.html.twig
    /**
     * @Route("/artist", name="artist")
     */
    public function index(UserRepository $repo): Response
    {
        $list = $repo->findAll();

        return $this->render('artist/index.html.twig', [
            'users' => $list,
        ]);
    }
}
