<?php

namespace Podorozhny\CoreBundle\Form\Type\Warehouse;

use Podorozhny\Manager\Warehouse\GoodManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GoodType
	extends AbstractType
{
	private $categoryManager;

	public function __construct(GoodManager $categoryManager)
	{
		$this->categoryManager = $categoryManager;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add(
				'name',
				'text',
				[
					'label'    => 'warehouse.good.label.name',
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
					'label'    => 'warehouse.good.label.description',
					'required' => false,
					'attr'     => [
						'tabindex' => 2,
					],
				]
			)
			->add(
				'count',
				'text',
				[
					'label'    => 'warehouse.good.label.count',
					'required' => true,
					'attr'     => [
						'tabindex' => 3,
					],
				]
			)
			->add(
				'width',
				'text',
				[
					'label'    => 'warehouse.good.label.width',
					'required' => true,
					'attr'     => [
						'tabindex' => 4,
						'rows'     => 3,
					],
				]
			)
			->add(
				'height',
				'text',
				[
					'label'    => 'warehouse.good.label.height',
					'required' => true,
					'attr'     => [
						'tabindex' => 5,
					],
				]
			)
			->add(
				'depth',
				'text',
				[
					'label'    => 'warehouse.good.label.depth',
					'required' => true,
					'attr'     => [
						'tabindex' => 6,
					],
				]
			)
			->add(
				'weight',
				'text',
				[
					'label'    => 'warehouse.good.label.weight',
					'required' => true,
					'attr'     => [
						'tabindex' => 7,
					],
				]
			)
			->add(
				'submit',
				'submit',
				[
					'label' => 'warehouse.good.label.submit',
					'attr'  => [
						'tabindex' => 8,
						'class'    => 'btn-primary btn-block',
					],
				]
			);
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(
			[
				'data_class'         => 'Podorozhny\Model\Warehouse\Good',
				'translation_domain' => 'forms',
				'csrf_protection'    => true,
				'csrf_field_name'    => 'csrf_token',
				'intention'          => 'warehouse_good',
			]
		);
	}

	public function getName()
	{
		return 'warehouse_good';
	}
}