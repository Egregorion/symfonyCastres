<?php

namespace App\Controller;

use App\Repository\StagiaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaire/{id}', name: 'app_stagiaire')]
    public function show(StagiaireRepository $sr, $id): Response
    {

        $stagiaire = $sr->find($id);

        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire
        ]);

    }

    #[Route('/stagiaire/add', name: 'app_add_stagiaire', priority: 2)]
    public function add(): Response
    {
        return $this->render('stagiaire/add.html.twig', [

        ]);
    }

}
