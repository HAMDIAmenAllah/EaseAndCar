<?php

namespace App\Form;

use App\Entity\DetailsFacture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailsFactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class,[
                'label' => 'Référence',
            ])
            ->add('type')
            ->add('debut', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('fin', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('nombreVehicules')
            ->add('tarifHT', TextType::class, [
            'label'=>'Tarif ht'])
            ->add('kilometrage',  TextType::class, [
                'label'=>'kilomètrage'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetailsFacture::class,
        ]);
    }
}
