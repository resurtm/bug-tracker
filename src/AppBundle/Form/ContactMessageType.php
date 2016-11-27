<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Your Name',
                'attr' => [
                    'placeholder' => 'Your Name',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Your Email',
                'attr' => [
                    'placeholder' => 'Your Email',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'placeholder' => 'Message',
                    'rows' => '6',
                ],
            ])
            ->add('send', SubmitType::class, array(
                'label' => 'Send Message',
                'attr' => [
                    'class' => 'btn btn-default btn-lg',
                ],
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\ContactMessage',
        ]);
    }
}
