<?php

namespace CommandeBundle\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitCommandeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('prixProduit')->add('quantiteProduit')
            ->add('idCommande',EntityType::class,array('class'=>'CommandeBundle:Commande','choice_label'=>'idCommande'))
            ->add('idProduit',EntityType::class,array('class'=>'EntrepotBundle:Produit','choice_label'=>'idProduit'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CommandeBundle\Entity\ProduitCommande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'commandebundle_produitcommande';
    }


}
