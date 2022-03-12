<?php

namespace App\Form;

use App\Entity\Rapport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Visiteur;
use App\Entity\Medecin;


class RapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //Création du formulaire
        $builder
            //Ajout d'un textArea
            ->add('bilan',TextareaType::class,array('attr' => array('class'=> 'input_form')))
            
            //On ajoute des listes déroulantes qui prennent comme valeurs les visiteurs et les medecins
            ->add('visiteur', EntityType::class, [
                'class' => Visiteur::class,
                'choice_label' => function (Visiteur $visiteur){
                    return $visiteur->getNom() . ' ' .$visiteur->getPrenom();
                }
            ])
            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' =>function (Medecin $medecin){
                    return $medecin->getNom() . ' ' .$medecin->getPrenom();
                }
                
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
        ]);
    }
}
