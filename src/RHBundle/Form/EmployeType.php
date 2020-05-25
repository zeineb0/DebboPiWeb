<?php

namespace RHBundle\Form;


use RHBundle\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Gregwar\CaptchaBundle\Type\CaptchaType;


class EmployeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('prenom')
            ->add('cin')
            ->add('salaire')
            ->add('recommandations')
            ->add('fkDep',EntityType::class,array( 'class'=>'RHBundle:Departement','choice_label'=>'nom'))
            ->add('email')
            ->add('imageFile',VichImageType::class)
            ->add('signalemp')
            ->add('nbcong')
            ->add('points')
            ->add('dateEmbauche')
            ->add('captcha', CaptchaType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RHBundle\Entity\Employe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'rhbundle_employe';
    }


}
