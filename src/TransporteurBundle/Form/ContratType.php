<?php

namespace TransporteurBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ContratType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('datedeb',DateType::class,['label'=>'Date Début :'])->add('datefin',DateType::class,['label'=>'Date Fin :'])->add('salaire',TextType::class,['label'=>'Le Salaire :'])
            ->add('FKidentrepot',EntityType::class,array(
                'class'=>'EntrepotBundle:Entrepot',
                'choice_label'=>'entreprise',
                'multiple'=>false,
                'label'=>"L'Entreprise :"))
            ->add('FKiduser',EntityType::class,array(
                'class'=>'AppBundle:User',
                'choice_label'=>'nom',
                'multiple'=>false,
                'label'=>'Nom du transporteur :'
                ))
            ;

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TransporteurBundle\Entity\Contrat'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'transporteurbundle_contrat';
    }


}
