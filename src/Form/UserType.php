<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\CallbackTransformer;
//use Symfony\Component\Form\FormEvent;
//use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    $builder
            ->add('login', null, ['label' => 'Логин'])
//            ->add('roles', ChoiceType::class, ['label' => false,
//		'choices' => ['Администратор' => 'ROLE_ADMIN'],
//		'multiple' => true,
//		'expanded' => true,
//		])
            ->add('roles', CheckboxType::class, ['label' => 'Администратор'])
            ->add('password', PasswordType::class, ['label' => 'Пароль',
		'required' => $options['required'],
		'mapped' => false,
		'hash_property_path' => 'password'])
        ;
	$builder->get('roles')->addModelTransformer(new CallbackTransformer(
			fn($rolesAsArray) => !empty($rolesAsArray),
			fn($rolesAsBool) => $rolesAsBool ? ['ROLE_ADMIN'] : []
		)
	);
//	$builder->addEventListener(FormEvents::PRE_SUBMIT,
//		function (FormEvent $event) {
//		    $passw = $event->getData()['password'];
//		    $form = $event->getForm();
//		    if ($passw === '') {
//			$form->add('password', PasswordType::class, [
//			    'mapped' => false,
//			    'hash_property_path' => null
//			]);
//		    }
//		}
//	);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
	    'required' => true,
        ]);
    }
}
