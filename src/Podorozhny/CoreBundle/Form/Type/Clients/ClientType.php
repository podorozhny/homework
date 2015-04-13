<?php

namespace Podorozhny\CoreBundle\Form\Type\Clients;

use Podorozhny\Manager\Clients\ClientManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType
	extends AbstractType
{
	private $clientManager;

	public function __construct(ClientManager $clientManager)
	{
		$this->clientManager = $clientManager;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add(
			'name',
			'text',
			[
				'label'    => 'clients.client.label.name',
				'required' => false,
				'attr'     => [
					'tabindex' => 1,
					'autofocus' => true,
				],
			]
		)
			->add(
				'phone',
				'text',
				[
					'label'    => 'clients.client.label.phone',
					'required' => false,
					'attr'     => [
						'tabindex' => 2,
					],
				]
			)
			->add(
				'email',
				'text',
				[
					'label'    => 'clients.client.label.email',
					'required' => false,
					'attr'     => [
						'tabindex' => 3,
					],
				]
			)
			->add(
				'notes',
				'textarea',
				[
					'label'    => 'clients.client.label.notes',
					'required' => false,
					'attr'     => [
						'tabindex' => 4,
						'rows'     => 3,
					],
				]
			)
			->add(
				'submit',
				'submit',
				[
					'label' => 'clients.client.label.submit',
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
				'data_class'         => 'Podorozhny\Model\Clients\Client',
				'translation_domain' => 'forms',
				'csrf_protection'    => true,
				'csrf_field_name'    => 'csrf_token',
				'intention'          => 'clients_client',
			]
		);
	}

	public function getName()
	{
		return 'clients_client';
	}
}