<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\UserAddress;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Nom du service'
            ])
            ->add('type', TextType::class, [
                'label'=>'Type du service',
                'help'=>'Electricité, Eau, Gaz ou autre...'
            ])
            ->add('link', TextType::class, [
                'label'=>'Lien du site officiel',
                'help'=>'Lien du site en https...'
            ])
            ->add('priceMonth', IntegerType::class, [
                'label'=>'Prix par mois',
                'required'=>false
            ])
            ->add('priceYear', IntegerType::class,[
                'label'=>'Prix par an',
                'required'=>false
            ])
            ->add('valid', SubmitType::class, [
                'label'=>'Enregistrer'
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
