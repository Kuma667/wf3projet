<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J\'accepte les CGU',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Merci de valider nos CGU.',
                    ]),
                ],
            ])
            ->add('numtel', TextType::class, [
                'label' => 'Numéro de téléphone'
            ])
            ->add('password', RepeatedType::class, [
                // instead of being	 set onto the object directly,
                // this is read and encoded in the controller
				'type' => PasswordType::class,
				'invalid_message' => "Les mots de passe ne sont pas identiques",
				'first_options' => [
					'label' => 'Mot de passe',
					'empty_data' => ' ',
				],
				'second_options' => [
					'label' => 'Confirmez le mot de passe',
					'empty_data' => ' '
				],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
