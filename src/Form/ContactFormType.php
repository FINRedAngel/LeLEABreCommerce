<?php

namespace App\Form;

use App\ValueObject\ContactForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TypeTextType::class, [
                'row_attr' =>[
                    'class' =>'mb-3',
                ],
                'label_attr' => [
                    'class' => 'col-form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom est vide'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'row_attr' =>[
                    'class' =>'mb-3',
                ],
                'label_attr' => [
                    'class' => 'col-form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'email est vide'
                    ])
                ]
            ])
            ->add('subject', TypeTextType::class, [
                'row_attr' =>[
                    'class' =>'mb-3',
                ],
                'label_attr' => [
                    'class' => 'col-form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le sujet est vide'
                    ])
                ]
            ])
            ->add('message', TextareaType::class, [
                'row_attr' =>[
                    'class' =>'mb-3',
                ],
                'label_attr' => [
                    'class' => 'col-form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le message est vide'
                    ])
                ]
            ])
            ->add('button', ButtonType::class, [
                'attr' => [
                    'class' => 'btn btn-secondary',
                    'data-bs-dismiss' => 'modal'
                ],
                'row_attr' => [
                    'class' => 'w-25 d-inline-block'
                ],
                'label' => 'Fermer'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
                'row_attr' => [
                    'class' => 'w-50 d-inline-block'
                ],
                'label' => 'Envoyer Message'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactForm::class,
        ]);
    }
}
