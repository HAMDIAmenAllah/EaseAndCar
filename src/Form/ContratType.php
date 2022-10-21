<?php

namespace App\Form;

use App\Entity\Contrat;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numContrat')
            ->add('date')
            ->add('raisonSociale')
            ->add('adresse')
            ->add('telephone')
            ->add('nom')
            ->add('adresseClient')
            ->add('telephoneClient')
            ->add('etat')
            ->add('prixHt')
            ->add('prixTtc')
            ->add('reference', TextType::class, [
                'attr' => [
                    'disabled' => true,
                ]
            ])
            ->add('emplacement')
            ->add('type')
            ->add('debut', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('fin', DateType::class, [
                'widget' => 'single_text',
                
            ])
            ->add('nombreVehicules')
            ->add('tarifHT')
            ->add('kilometrage')
            ->add('RCS')
            ->add('prenom')
            ->add('mail')
            ->add('societeClient')
            ->add('formeJuridique')
            ->add('tva')
            ->add('siret')
            ->add('immatriculation')
            ->add('carburant')

            
            


            // ->add('note', TextType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
