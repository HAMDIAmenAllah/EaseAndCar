<?php

namespace App\Form;

use App\Entity\Facture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numFacture')
            ->add('date', DateType::class,[
                'widget'=>'single_text',
    
            ])
            ->add('raisonSociale')
            ->add('adresse')
            ->add('telephone')
            ->add('nom')
            ->add('adresseClient')
            ->add('telephoneClient')
            ->add('prixHt')
            ->add('prixTtc')
            ->add('etat')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
