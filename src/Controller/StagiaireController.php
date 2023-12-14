<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        //on initialise un objet stagiaire vide 
        $stagiaire = new Stagiaire; 
        //on initialise le formulaire correspondant à l'entité 
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        //on dit au formulaire de gérer la requête
        $form->handleRequest($request);
        //Si des données valides sont envoyées 
        if($form->isSubmitted()&&$form->isValid()){
            //on alimente l'objet avec les données du formulaire
            $stagiaire = $form->getData();
            //on va chercher l'entity manager (injecté dans la fonction) et on "enregistre" le nouvel objet
            $em->persist($stagiaire);
            //puis on l'envoi en base de données
            $em->flush();
            //enfin on redirige vers la page d'accueil
            return $this->redirectToRoute('app_home'); 
        }
        //Je check si j'ai un utilisateur connecté
        $user = $this->getUser();
        //Si j'en ai un je rend le formulaire 
        if($user){
            return $this->render('stagiaire/add.html.twig', [
                'form' => $form
            ]);
        //dans le cas contraire je redirige vers le login
        }else{
            return $this->redirectToRoute('app_login');
        }
        
    }

    #[Route('/stagiaire/{id}/update', name: 'app_update_stagiaire')]
    public function update(EntityManagerInterface $em, Request $request, StagiaireRepository $sr, $id)
    {
        //récupérer l'élément à mettre à jour
        $stagiaire = $sr->find($id);
        //on initialise le formulaire correspondant à l'entité 
        $form = $this->createForm(StagiaireType::class, $stagiaire);

        $form->handleRequest($request);
        //Si des données valides sont envoyées 
        if($form->isSubmitted()&&$form->isValid()){
            //on alimente l'objet avec les données du formulaire
            $stagiaire = $form->getData();
            //on va chercher l'entity manager (injecté dans la fonction) et on "enregistre" le nouvel objet
            $em->persist($stagiaire);
            //puis on l'envoi en base de données
            $em->flush();
            //enfin on redirige vers la page d'accueil
            return $this->redirectToRoute('app_home'); 
        }

        return $this->render('stagiaire/update.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/stagiaire/{id}/delete', name: 'app_delete_stagiaire')]
    public function delete(StagiaireRepository $sr, EntityManagerInterface $em, $id)
    {
        //récupérer l'élément à supprimer
        $stagiaire = $sr->find($id);
        
        //décrire ce que l'on souhaite faire, à savoir SUPPRIMER l'élément
        $em->remove($stagiaire);

        //exécuter la commande de suppression 
        $em->flush();

        //rediriger vers l'accueil
        return $this->redirectToRoute('app_home');
    }
}
