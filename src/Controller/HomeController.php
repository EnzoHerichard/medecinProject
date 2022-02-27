<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Rapport;
use App\Form\RapportType;
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
        $form = $this->createForm(RapportType::class,$rapport);
                
        $form->handleRequest($request);

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
     * @Route("/Rapport/show/{id}", name="rapport_show")
     */
    public function show()
    {

    }
}
