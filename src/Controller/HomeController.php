<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Rapport;
use App\Entity\Visiteur;
use App\Repository\VisiteurRepository;
use App\Repository\RapportRepository;
use App\Form\RapportType;
use App\Form\ShowType;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/Rapport/new", name="rapport_create")
     */
    public function create(Rapport $rapport = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$rapport){
            $rapport = new Rapport();
        }
        //Création du form
        $form = $this->createForm(RapportType::class,$rapport);
                
        $form->handleRequest($request);

        //si valide on ajoute la date du jour au rapport et on envoie en bdd
        if($form->isSubmitted() && $form->isValid()) {
            if(!$rapport->getId()){
                $rapport->setDate(new \DateTime());
            }
            
            $manager-> persist($rapport);
            $manager-> flush();
        }
            return $this->render('home/create.html.twig', [
                'formRapport' => $form->createView()
            ]);
        
        
    }
    /**
     * @Route("/Rapport/preshow", name="rapport_preshow")
     * @Route("/Rapport/{id}/show", name="rapport_show")
     */
    public function Show(Visiteur $visiteur = null,Request $request)
    {
        if(!$visiteur){
            $visiteur = new Visiteur();
        }
        
        //Création du form
        $form = $this->createForm(ShowType::class,null, [
            'data_class' => Rapport::class
        ]);
        $form->handleRequest($request);
        
        $id = null;

        //si valide on recupere l'id et le visiteur et on renvoie vers la page d'affichage
        if($form->isSubmitted()){
            $id = $form->getData()->getVisiteur()->getId();
            $visiteur = $form->getData()->getVisiteur();

            return $this->redirectToRoute('rapport_show', [
                'visiteur' => $visiteur,
                'id' => $id,
            ]);
        }
        
        
        return $this->render('home/show.html.twig', [
            'formVisiteur' => $form->createView(),
            'haveid' => $visiteur->getId() !== null,
            'visiteur' => $visiteur
        ]); 
        
    }
    
    
}
