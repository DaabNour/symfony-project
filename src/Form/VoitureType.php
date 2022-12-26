<?php

namespace App\Form;


use App\Entity\Modele;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;


class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Serie' , TextType::class)
            ->add('date_mise', DateType::class)
            ->add('marche',TextType::class)
            ->add('locations',TextType::class)
            ->add('modele',EntityType::class)
        ->add('modele',EntityType::class,
        ['class'=>Modele::class,
            'choice_label'=>'libelle']);


        //  ->add("ajouter",submit::class)




    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([


        ]);
    }
    public function getName(){
        return "Voiture";
    }

}