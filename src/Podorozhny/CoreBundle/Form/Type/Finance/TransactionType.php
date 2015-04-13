<?php

namespace Podorozhny\CoreBundle\Form\Type\Finance;

use Podorozhny\Manager\Finance\TransactionManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TransactionType
	extends AbstractType
{
	private $categoryManager;

	public function __construct(TransactionManager $categoryManager)
	{
		$this->categoryManager = $categoryManager;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add(
			'title',
			'text',
			[
				'label'    => 'finance.transaction.label.title',
				'required' => true,
				'attr'     => [
					'tabindex' => 1,
				],
			]
		)
			->add(
				'description',
				'textarea',
				[
					'label'    => 'finance.transaction.label.description',
					'required' => false,
					'attr'     => [
						'tabindex' => 2,
					],
				]
			)
			->add(
				'amount',
				'text',
				[
					'label'    => 'finance.transaction.label.amount',
					'required' => true,
					'attr'     => [
						'tabindex' => 3,
					],
				]
			)
			->add(
				'submit',
				'submit',
				[
					'label' => 'finance.transaction.label.submit',
					'attr'  => [
						'tabindex' => 4,
						'class'    => 'btn-primary btn-block',
					],
				]
			);
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(
			[
				'data_class'         => 'Podorozhny\Model\Finance\Transaction',
				'translation_domain' => 'forms',
				'csrf_protection'    => true,
				'csrf_field_name'    => 'csrf_token',
				'intention'          => 'finance_transaction',
			]
		);
	}

	public function getName()
	{
		return 'finance_transaction';
	}
}