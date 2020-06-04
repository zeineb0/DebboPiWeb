<?php

namespace TransporteurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use EntrepotBundle\Entity\Commande;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LivraisonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateLivraison')->add('adresseLivraison')->add('etatLivraison')->add('acceptation')
            ->add('fkCommande', EntityType::class,array(
                'class'=>'EntrepotBundle:Commande',
                'choice_label'=>'idCommande',
                'multiple'=>false
            ))
            ->add('fkUser' ,EntityType::class,array(
        'class'=>'AppBundle:User',
        'choice_label'=>'nom',
        'multiple'=>false
            ))
            ->add('Ajouter',SubmitType::class,
                ['attr'=>['formnovalidate'=>'formnovalidate']]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TransporteurBundle\Entity\Livraison'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'transporteurbundle_livraison';
    }


}
