<?php

namespace App\Form;

use App\Entity\Rapport;
use App\Entity\Visiteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        //On ajoute une liste déroulantes qui prend comme valeur les visiteurs 
        ->add('visiteur', EntityType::class, [
            'multiple' => false,
            'class' => Visiteur::class,
            'choice_label' => function (Visiteur $visiteur){
                return /* $visiteur->getId().' '. */$visiteur->getNom() . ' ' .$visiteur->getPrenom();
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
