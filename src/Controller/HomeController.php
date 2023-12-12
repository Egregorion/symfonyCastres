<?php

namespace App\Controller;

use App\Repository\StagiaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(StagiaireRepository $sr): Response
    {

        $stagiaires = $sr->findAll();
        //dump($stagiaires);

        return $this->render('home/index.html.twig', [
            'stagiaires' => $stagiaires
        ]);
    }
}
