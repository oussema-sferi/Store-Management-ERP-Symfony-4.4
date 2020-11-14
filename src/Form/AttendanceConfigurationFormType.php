<?php

namespace App\Form;

use App\Entity\AttendanceConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttendanceConfigurationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bonusAmount')
            ->add('malusAmount')
            ->add('checkInTime')
            ->add('checkOutTime')
            ->add('store')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AttendanceConfiguration::class,
        ]);
    }
}
