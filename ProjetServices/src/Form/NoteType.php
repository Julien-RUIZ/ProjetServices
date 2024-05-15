<?php

namespace App\Form;

use App\Controller\Note\Reminder;
use App\Entity\Note;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function __construct(private readonly MailerInterface $mailer, private readonly Security $security, private Reminder $reminder)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'=>'Titre',
            ])
            ->add('text', TextareaType::class, [
                'label'=>'Texte',
                'sanitize_html' => true,
            ])
            ->add('reminder', CheckboxType::class, [
                'label'=>'Relance par mail',
                'required'=>false,
                'help'=>'Si vous souhaitez une relance de la note par mail, merci de cocher la case puis de valider. 
                Un formulaire va vous être présenté, ci-dessous, afin de finir la configuration de la relance.',
            ])
            ->add('save', SubmitType::class, [
               'label'=>'Enregistrer',
           ])
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'ShowField']);
    }

    /**
     * @param PreSetDataEvent $event
     * @return void
     * Displaying the two additional fields after the validation of the 'relance' checkbox
     */
    public function ShowField(PreSetDataEvent $event){
        $data = $event->getData();
        if($data->isreminder()){
            $form = $event->getForm();
            $form->add('date', DateType::class,[
                'required'=>false,
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d'), // Date actuelle
                ],
            ]);
            $form->add('emailsend', EmailType::class,[
                'required'=>false,
                'label'=>'Adresse mail du destinataire'
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
