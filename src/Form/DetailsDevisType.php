<?php

namespace App\Form;

use App\Entity\DetailsDevis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailsDevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class,[
                'label' => 'Référence',
            ])
            ->add('type', TextType::class,[
                'label' => 'Type',
            ])
            ->add('debut', DateType::class, [
                'input' => 'datetime_immutable',
                'widget' =>'single_text',
                'required' =>true,
                'label' => 'Date Début',
            ])
            ->add('fin', DateType::class,[
                'widget'=>'single_text',
                'input' => 'datetime_immutable',
                'required'=>true,
                'label' => 'Date Fin',
            ])
            ->add('nombreVehicules', IntegerType::class,[
                'label' => 'Nombre Véhicules',
                'attr' => [
                    'placeholder' => '0',
                    'min' => 0,
                ],
            ])
            ->add('tarifHT', NumberType::class,[
                'label' => 'Tarif HT',
                'attr' => [
                    'placeholder' => '100€',
                    'min' => 0,
                ],
            ])
            ->add('kilometrage', NumberType::class,[
                'label' => 'Kilométrage',
                'attr' => [
                    'placeholder' => '100km',
                    'min' => 0,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetailsDevis::class,
        ]);
    }
}
