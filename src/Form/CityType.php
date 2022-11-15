<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('CountryID', ChoiceType::class, [
                'choices'  => [
                    'Polska' => 'PL',
                    'Niemcy' => 'DE',
                    'Hiszpania' => 'ES',
                    'Francja' => 'FR',
                    'Wielka Brytania' => 'UK',
                ]])
            ->add('Latitude')
            ->add('Longitude')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => City::class,
        ]);
    }
}
