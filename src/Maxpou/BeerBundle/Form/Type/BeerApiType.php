<?php

namespace Maxpou\BeerBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BeerApiType extends BeerType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('brewery')
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

    public function getBlockPrefix()
    {
        return '';
    }
}
