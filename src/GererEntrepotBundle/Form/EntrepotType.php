<?php

namespace GererEntrepotBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EntrepotType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('adresse')->add('numFiscale')->add('quantiteMax')->add('etat', ChoiceType::class, [
            'choices'  => [
                'Libre' => 'Libre',
                'Loué' => 'Loué',
                'A Louer' => 'A Louer',
            ],

        ])

            -> add('prixLocation')
            ->add('entreprise');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GererEntrepotBundle\Entity\Entrepot'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gererentrepotbundle_entrepot';
    }


}
