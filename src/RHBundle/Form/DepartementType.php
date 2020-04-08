<?php

namespace RHBundle\Form;
use EntrepotBundle\Entity\Entrepot;
use EntrepotBundle\EntrepotBundle;
use RHBundle\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class DepartementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('etage')
            ->add('nbsalles')
            ->add('budgetannuel')
            ->add('fkEnt',EntityType::class,array( 'class'=>'EntrepotBundle:Entrepot','choice_label'=>'entreprise'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RHBundle\Entity\Departement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'rhbundle_departement';
    }


}
