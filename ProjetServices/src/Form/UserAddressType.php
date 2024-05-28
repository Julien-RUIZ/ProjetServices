<?php

namespace App\Form;

use App\Entity\UserAddress;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAddressType extends AbstractType
{
    public function __construct(public readonly EntityManagerInterface $entityManager)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', IntegerType::class,[
                'label'=>'Numéro'
            ])
            ->add('Address', TextType::class,[
                'required'=>false
            ])
            ->add('city', TextType::class,[
                'required'=>false
            ])
            ->add('postalCode', IntegerType::class,[
                'required'=>false
            ])
            ->add('mainAddress', ChoiceType::class,[
                'choices'=>[
                    'Principale'=>true,
                    'Secondaire'=>false
                ],
                'label'=>'Adresse principale ou secondaire',
                'help'=>'Vous ne pouvez avoir qu\'un domicile en principale. Si vous en avez déjà un, l\'enregistrement se fera automatiquement en secondaire.'
            ])
            ->add('additional', TextType::class,[
                'required'=>false,
                'label'=>'Complément d\'adresse',
                'help'=>'Résidence, bâtiment, étage'
            ])
            ->add('dwellingType', ChoiceType::class, [
                'choices'=>[
                    'Appartement'=>'Appartement',
                    'Maison'=>'Maison',
                ],
                'label'=>'Type de logement'
            ])
            ->add('dwellingSize',IntegerType::class, [
                'label'=>'Taille en m²',
                'required'=>true
            ] )
            ->add('rental', ChoiceType::class, [
                'choices'=>[
                    'oui'=>'1',
                    'non'=>'0',
                    ],
                'label'=>'Location'
                ])
            ->add('valid', SubmitType::class,[
                'label'=>'Enregistrer'
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->mainAddress(...) )
        ;
    }

    private function mainAddress(PreSubmitEvent $event):void
    {
        $data = $event->getData();
        $main = $this->entityManager->getRepository(UserAddress::class)->findmainaddress();
        if ($data['mainAddress']==='1'){
            for ($i=0; $i<count($main); $i++){
                if ($main[$i]['mainAddress']===true && $main[$i]['Address'] != $data['Address']){
                    $data['mainAddress']='0';
                    $event->setData($data);
                }
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserAddress::class,
        ]);
    }
}
