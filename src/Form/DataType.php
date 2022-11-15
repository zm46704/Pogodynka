<?php

namespace App\Form;

use App\Entity\Data;
use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class DataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class)
            ->add('temperature')
            ->add('wind')
            ->add('clouds', ChoiceType::class, [
                'choices'  => [
                    'Słonecznie' => 'Słonecznie',
                    'Burza' => 'Burza',
                    'Pochmurnie' => 'Pochmurnie',
                    'Deszcz' => 'Deszcz',
                    'Śnieg' => 'Śnieg',
                    'Noc' => 'Noc',
                ]])
            ->add('humidity')
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'choice_value' => 'id'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Data::class,
        ]);
    }
}
