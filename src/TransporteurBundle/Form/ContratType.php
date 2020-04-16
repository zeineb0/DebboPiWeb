<?php

namespace TransporteurBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('datedeb')->add('datefin')->add('salaire')
            ->add('FKidentrepot',EntityType::class,array(
                'class'=>'EntrepotBundle:Entrepot',
                'choice_label'=>'entreprise',
                'multiple'=>false))
            ->add('FKiduser',EntityType::class,array(
                'class'=>'AppBundle:User',
                'choice_label'=>'nom',
                'multiple'=>false))
            ->add('Ajouter',SubmitType::class,
                ['attr'=>['formnovalidate'=>'formnovalidate']]);

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
