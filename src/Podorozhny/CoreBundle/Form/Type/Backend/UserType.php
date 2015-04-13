<?php

namespace Podorozhny\CoreBundle\Form\Type\Backend;

use Doctrine\ORM\EntityRepository;
use Podorozhny\Manager\Backend\UserManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType
	extends AbstractType
{
	private $userManager;

	public function __construct(UserManager $userManager)
	{
		$this->userManager = $userManager;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add(
			'name',
			'text',
			[
				'label'    => 'backend.user.label.name',
				'required' => false,
				'attr'     => [
					'tabindex'  => 1,
					'autofocus' => true,
				],
			]
		)
			->add(
				'group',
				'entity',
				[
					'label'         => 'backend.user.label.group',
					'required'      => true,
					'attr'          => [
						'tabindex' => 2,
					],
					'empty_value'   => 'backend.user.empty.group',
					'class'         => 'Podorozhny\Model\Backend\UserGroup',
					'property'      => 'name',
					'query_builder' => function (EntityRepository $er) {
						return $er->createQueryBuilder('g')
							->andWhere('g.name != :groupName')
							->setParameter(':groupName', 'Совет директоров')
							->orderBy('g.name', 'ASC');
					},
				]
			)
			->add(
				'email',
				'text',
				[
					'label'    => 'backend.user.label.email',
					'required' => true,
					'attr'     => [
						'tabindex' => 3,
					],
				]
			)
			->add(
				'plainPassword',
				'password',
				[
					'label'    => 'backend.user.label.plainPassword',
					'required' => true,
					'attr'     => [
						'tabindex' => 4,
					],
				]
			)
			->add(
				'submit',
				'submit',
				[
					'label' => 'backend.user.label.submit',
					'attr'  => [
						'tabindex' => 5,
						'class'    => 'btn-primary btn-block',
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
				'intention'          => 'backend_user',
			]
		);
	}

	public function getName()
	{
		return 'backend_user';
	}
}