<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' =>'Email :'
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'=> PasswordType::class,
                'invalid_message'=>'Les mots de passe sont différent...',
                'options'=> ['attr' => ['class' =>'password_field']],
                'required' => false,
                'first_options' =>['label' =>'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe']
            ])
            ->add('firstName',TextType::class, [
                'label' =>'Prénom :'
            ])
            ->add('lastName',TextType::class, [
                'label' =>'Nom de Famille :'
            ])
            ->add('Envoyer',SubmitType::class, [
                'attr'=>['class' => 'btn btn-primary']
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
