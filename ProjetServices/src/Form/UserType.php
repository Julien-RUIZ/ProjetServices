<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
                'required'=>true
            ])
            ->add('email', EmailType::class,[
                'required'=>true
            ])
            ->add('name', TextType::class,[
                'required'=>true
            ])
            ->add('firstname', TextType::class,[
                'required'=>true
            ])
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text',
                'required'=>true
            ])
            ->add('telephone', IntegerType::class,[
                'label'=>'Numéro de téléphone'
            ])
            ->add('save',SubmitType::class, [
                'label'=>'Enregistrer'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
