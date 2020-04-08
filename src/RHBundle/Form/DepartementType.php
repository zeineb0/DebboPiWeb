<?php

namespace RHBundle\Form;
use EntrepotBundle\Entity\Entrepot;
use EntrepotBundle\EntrepotBundle;
use RHBundle\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('fkEnt', Entrepot::class, [
                // looks for choices from this entity
                'class' => Entrepot::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'Entrepot.entreprise',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ]);
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
