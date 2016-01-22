<?php

namespace Maxpou\BeerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class BeerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('alcohol')
            ->add('brewery', EntityType::class, array(
                'class' => 'Maxpou\BeerBundle\Entity\Brewery',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Maxpou\BeerBundle\Entity\Beer'
        ));
    }
}
