<?php

namespace App\Form;

use App\Entity\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeEntreprise', ChoiceType::class, [
                "choices" => [
                    "Sélectionner votre choix" => 0,
                    "Entreprise privée" => "Entreprise privée",
                    "Service jeunesse de mairie" => "Service jeunesse de mairie",
                    "Association" => "Association",
                    "Agence de voyage" =>"Agence de voyage",
                    "IME" => "IME",
                    "EHPAD" => "EHPAD",
                    ],
            ])
            ->add('nomEntreprise', TextType::class,[
                'attr' => ['placeholder' => 'Ease & Car'],
            ])
            ->add('adresseEmail', EmailType::class,[
                'attr' => ['placeholder' => 'contact@easeandcar.fr'],
            ])
            ->add('numeroTel', TextType::class,[
                'attr' => ['placeholder' => '+33 6 63 15 12 17'],
            ])
            ->add('adresseSiege', TextType::class, [
                'attr' => ['placeholder' => '7 Rue Jacquard, 91280 Saint-Pierre-du-Perray'],
            ])
            ->add('departementDepart', ChoiceType::class,[
                'choices' => [
                    "Sélectionner votre département :" => 0,
                    "01 - Ain" => "01 - Ain",
                    "02 - Aisne" => "02 - Aisne",
                    "03 - Allier" => "03 - Allier",
                    "04 - Alpes-de-Haute-Provence" => "04 - Alpes-de-Haute-Provence",
                    "05 - Hautes-alpes" => "05 - Hautes-alpes",
                    "06 - Alpes-maritimes" => "06 - Alpes-maritimes",
                    "07 - Ardèche" => "07 - Ardèche",
                    "08 - Ardennes" => "08 - Ardennes",
                    "09 - Ariège" => "09 - Ariège",
                    "10 - Aube" => "10 - Aube",
                    "11 - Aude" => "11 - Aude",
                    "12 - Aveyron" => "12 - Aveyron",
                    "13 - Bouches-du-Rhône" => "13 - Bouches-du-Rhône",
                    "14 - Calvados" => "14 - Calvados",
                    "15 - Cantal" => "15 - Cantal",
                    "16 - Charente" => "16 - Charente",
                    "17 - Charente-maritime" => "17 - Charente-maritime",
                    "18 - Cher" => "18 - Cher",
                    "19 - Corrèze" => "19 - Corrèze",
                    "21 - Côte-d'Or" => "21 - Côte-d'Or",
                    "22 - Côtes-d'Armor" => "22 - Côtes-d'Armor",
                    "23 - Creuse" => "23 - Creuse",
                    "24 - Dordogne" => "24 - Dordogne",
                    "25 - Doubs" => "25 - Doubs",
                    "26 - Drôme" => "26 - Drôme",
                    "27 - Eure" => "27 - Eure",
                    "28 - Eure-et-loir" => "28 - Eure-et-loir",
                    "29 - Finistère" => "29 - Finistère",
                    "30 - Gard" => "30 - Gard",
                    "31 - Haute-garonne" => "31 - Haute-garonne",
                    "32 - Gers" => "32 - Gers",
                    "33 - Gironde" => "33 - Gironde",
                    "34 - Hérault" => "34 - Hérault",
                    "35 - Ille-et-vilaine" => "35 - Ille-et-vilaine",
                    "36 - Indre" => "36 - Indre",
                    "37 - Indre-et-loire" => "37 - Indre-et-loire",
                    "38 - Isère" => "38 - Isère",
                    "39 - Jura" => "39 - Jura",
                    "40 - Landes" => "40 - Landes",
                    "41 - Loir-et-cher" => "41 - Loir-et-cher",
                    "42 - Loire" => "42 - Loire",
                    "43 - Haute-loire" => "43 - Haute-loire",
                    "44 - Loire-atlantique" => "44 - Loire-atlantique",
                    "45 - Loiret" => "45 - Loiret",
                    "46 - Lot" => "46 - Lot",
                    "47 - Lot-et-garonne" => "47 - Lot-et-garonne",
                    "48 - Lozère" => "48 - Lozère",
                    "49 - Maine-et-loire" => "49 - Maine-et-loire",
                    "50 - Manche" => "50 - Manche",
                    "51 - Marne" => "51 - Marne",
                    "52 - Haute-marne" => "52 - Haute-marne",
                    "53 - Mayenne" => "53 - Mayenne",
                    "54 - Meurthe-et-moselle" => "54 - Meurthe-et-moselle",
                    "55 - Meuse" => "55 - Meuse",
                    "56 - Morbihan" => "56 - Morbihan",
                    "57 - Moselle" => "57 - Moselle",
                    "58 - Nièvre" => "58 - Nièvre",
                    "59 - Nord" => "59 - Nord",
                    "60 - Oise" => "60 - Oise",
                    "61 - Orne" => "61 - Orne",
                    "62 - Pas-de-calais" => "62 - Pas-de-calais",
                    "63 - Puy-de-dôme" => "63 - Puy-de-dôme",
                    "64 - Pyrénées-atlantiques" => "64 - Pyrénées-atlantiques",
                    "65 - Hautes-Pyrénées" => "65 - Hautes-Pyrénées",
                    "66 - Pyrénées-orientales" => "66 - Pyrénées-orientales",
                    "67 - Bas-rhin" => "67 - Bas-rhin",
                    "68 - Haut-rhin" => "68 - Haut-rhin",
                    "69 - Rhône" => "69 - Rhône",
                    "70 - Haute-saône" => "70 - Haute-saône",
                    "71 - Saône-et-loire" => "71 - Saône-et-loire",
                    "72 - Sarthe" => "72 - Sarthe",
                    "73 - Savoie" => "73 - Savoie",
                    "74 - Haute-savoie" => "74 - Haute-savoie",
                    "75 - Paris" => "75 - Paris",
                    "76 - Seine-maritime" => "76 - Seine-maritime",
                    "77 - Seine-et-marne" => "77 - Seine-et-marne",
                    "78 - Yvelines" => "78 - Yvelines",
                    "79 - Deux-sèvres" => "79 - Deux-sèvres",
                    "80 - Somme" => "80 - Somme",
                    "81 - Tarn" => "81 - Tarn",
                    "82 - Tarn-et-Garonne" => "82 - Tarn-et-Garonne",
                    "83 - Var" => "83 - Var",
                    "84 - Vaucluse" => "84 - Vaucluse",
                    "85 - Vendée" => "85 - Vendée",
                    "86 - Vienne" => "86 - Vienne",
                    "87 - Haute-vienne" => "87 - Haute-vienne",
                    "88 - Vosges" => "88 - Vosges",
                    "89 - Yonne" => "89 - Yonne",
                    "90 - Territoire de belfort" => "90 - Territoire de belfort",
                    "91 - Essonne" => "91 - Essonne",
                    "92 - Hauts-de-seine" => "92 - Hauts-de-seine",
                    "93 - Seine-Saint-Denis" => "93 - Seine-Saint-Denis",
                    "94 - Val-de-marne" => "94 - Val-de-marne",
                    "95 - Val-d'Oise" => "95 - Val-d'Oise",
                ]
            ])
            ->add('debutLocation', DateType::class,[
                'widget'=>'single_text',
                'required'=>true,
            ])
            ->add('finLocation', DateType::class,[
                'widget'=>'single_text',
                'required'=>true,
            ])
            ->add('typeVehicule', ChoiceType::class, array(
                'choices' => array(
                    'Minibus' => 'Minibus',
                    'Minibus handicap' => 'Minibus handicap',
                    'SUV' => 'SUV',
                    'Citadine' => 'Citadine',
                    'Citadine handicap' => 'Citadine handicap',
                ),
                'expanded' => true,
            ))
            ->add('typeLocation', ChoiceType::class, array(
                'choices' => array(
                    'Loisir' => 'Loisir',
                    'Travail' => 'Travail',
                    'Autres' => 'Autres',
                ),
                'expanded' => true,
            ))
            ->add('nombrePlaces', IntegerType::class,[
                'attr' => [
                    'placeholder' => '0',
                    'min' => 0,
                ],
            ])
            ->add('besoinChauffeur', ChoiceType::class, array(
                'choices' => array(
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ),
                'expanded' => true,
            ))
            ->add('message', TextareaType::class, [
                'attr' => [
                    'required' => false,
                ]
            ])
            /* ->add('statut', ChoiceType::class, [
                "choices" => [
                    "en attente" => "en attente",
                    "en cours" => "en cours",
                    "validé" => "validé",
                    "refusé" => "refusé",
                    ],
            ]) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
