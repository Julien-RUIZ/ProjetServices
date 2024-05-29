<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\UserAddress;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{

private $datapriceMonth;
private $datapriceYear;
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Nom du service'
            ])
            ->add('type', ChoiceType::class, [
                'choices'=>[
                    '--'=>'--',
                    'Impôts'=>'Impôts',
                    'Eau'=>'Eau',
                    'Électricité'=>'Électricité',
                    'Gaz'=>'Gaz',
                    'Assurance habitation'=>'Assurance habitation',
                    'Assurance véhicule'=>'Assurance véhicule',
                    'Forfait téléphonie'=>'Forfait téléphonie',
                    'Forfait Box internet'=>'Forfait Box internet',
                    'Autre'=>'Autre'
                ],
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
            ->addEventListener(FormEvents::PRE_SET_DATA, $this->PriceChange(...))
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->ServicePrice(...));

    }
    public function PriceChange(PreSetDataEvent $preSetDataEvent){
        if($preSetDataEvent->getData()->getPriceMonth() !== null && $preSetDataEvent->getData()->getPriceYear() !== null){
            $this->datapriceMonth = $preSetDataEvent->getData()->getPriceMonth();
            $this->datapriceYear = $preSetDataEvent->getData()->getPriceYear();
        }

    }
    public function ServicePrice(PreSubmitEvent $event):void
    {
        $data = $event->getData();
        if (empty($data['priceYear']) || intval($data['priceMonth']) != $this->datapriceMonth && intval($data['priceYear']) === $this->datapriceYear){
            $data['priceYear'] = $data['priceMonth'] * 12;
        }elseif (empty($data['priceMonth']) || intval($data['priceMonth']) === $this->datapriceMonth && intval($data['priceYear']) != $this->datapriceYear){
            $data['priceMonth'] = $data['priceYear'] / 12;
        }
        $event->setData($data);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
