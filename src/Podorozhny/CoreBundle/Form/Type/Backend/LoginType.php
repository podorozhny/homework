<?php

namespace Podorozhny\CoreBundle\Form\Type\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginType
	extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add(
			'email',
			'email',
			[
				'label'    => 'backend.login.label.email',
				'required' => true,
				'attr'     => [
					'tabindex'  => 1,
					'autofocus' => true,
					'placeholder' => 'backend.login.label.email',
				],
			]
		)
			->add(
				'password',
				'password',
				[
					'label'    => 'backend.login.label.password',
					'required' => true,
					'attr'     => [
						'tabindex' => 2,
						'placeholder' => 'backend.login.label.password',
					],
				]
			)
			->add(
				'submit',
				'submit',
				[
					'label' => 'backend.login.label.submit',
					'attr'  => [
						'tabindex' => 3,
						'class'    => 'btn-lg btn-primary btn-block',
					],
				]
			);
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(
			[
				'data_class'         => 'Podorozhny\Model\Backend\User',
				'translation_domain' => 'forms',
				'csrf_protection'    => true,
				'csrf_field_name'    => 'csrf_token',
				'intention'          => 'backend_login',
			]
		);
	}

	public function getName()
	{
		return 'backend_login';
	}
}