<?php
namespace GererEntrepotBundle\Form;
use GererEntrepotBundle\Data\SearchData;
use GererEntrepotBundle\Entity\Entrepot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse',TextType::class, [
                'label' => false,
                'required' => false,
                'attr'=>['placeholder'=>'Rechercher'] ])
            ->add('entreprise', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Entrepot::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('min', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix min'
                ]
            ])
            ->add('max', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix max'
                ]




            ]);
    }




    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>SearchData::class,
            'method'=>'GET',
            'csrf_protection'=>false ])  ;
    }


public function getBlockPrefix()
{
    return '';


}



}

