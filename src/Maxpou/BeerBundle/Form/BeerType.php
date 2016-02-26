<?php

namespace Maxpou\BeerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

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
            ->add('alcohol', NumberType::class, array(
                'description'  => 'Beer alcohol degree (must be > 5°)',
            ))
            ->add('brewery', EntityType::class, array(
                'class'        => 'Maxpou\BeerBundle\Entity\Brewery',
                'description'  => 'Brewery id',
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
            'data_class'         => 'Maxpou\BeerBundle\Entity\Beer',
            'csrf_protection'    => false,
            'allow_extra_fields' => true
        ));
    }

    public function getName()
    {
        return '';
    }
}
