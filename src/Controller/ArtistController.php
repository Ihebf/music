<?php

namespace App\Controller;

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
    public function index(): Response
    {
        return $this->render('artist/index.html.twig', [
            'controller_name' => 'ArtistController',
        ]);
    }
}
