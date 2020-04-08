<?php

namespace GererEntrepotBundle\Form;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class LocationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebLocation', DateType::class, [
                'placeholder' => '',
            ])
            ->add('dateFinLocation', DateType::class, [
                 'placeholder' => '',
            ])
            ->add('prixLocation')
            ->add('fkEntrepot',EntityType::class,array( 'class'=>'GererEntrepotBundle:Entrepot','choice_label'=>'idEntrepot'))
            ->add('fkUser',EntityType::class,array('class'=>'EntrepotBundle:Utilisateur','choice_label'=>'id'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GererEntrepotBundle\Entity\Location'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gererentrepotbundle_location';
    }


}
