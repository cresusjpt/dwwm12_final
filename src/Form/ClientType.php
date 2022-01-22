<?php

namespace App\Form;

use App\Entity\CLient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('codepostal')
            ->add('ville')
            ->add('adresse', TextareaType::class, [
                'attr' => [
                    'rows' => 10,
                    'cols' => 20,
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CLient::class,
        ]);
    }
}
