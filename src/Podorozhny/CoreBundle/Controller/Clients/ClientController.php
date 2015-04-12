<?php

namespace Podorozhny\CoreBundle\Controller\Clients;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Podorozhny\CoreBundle\Controller\AbstractController;
use Podorozhny\Manager\Clients\ClientManager;

class ClientController
	extends AbstractController
{
	public function __construct(
		EntityManagerInterface $entityManager,
		PaginatorInterface $paginator,
		ClientManager $clientManager
	) {
		$this->entityManager = $entityManager;
		$this->paginator     = $paginator;
		$this->clientManager = $clientManager;
	}

	public function listAction($page)
	{
		$query = $this->entityManager->createQuery(
			'SELECT c
			FROM Clients:Client c
			ORDER BY c.createdAt DESC'
		);

		$pagination = $this->paginator->paginate(
			$query,
			$this->getRequest()->query->get('page', $page),
			10
		);

		return $this->render(
			'CoreBundle:Clients/Client:list.html.twig',
			['pagination' => $pagination]
		);
	}

	public function newAction()
	{
		$form = $this->createForm('clients_client');

		return $this->render(
			'CoreBundle:Clients/Client:new.html.twig',
			['form' => $form->createView()]
		);
	}

	public function createAction()
	{
		$client = $this->clientManager->create();

		$form = $this->createForm('clients_client');
		$form->setData($client);
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$this->clientManager->update($client);

			$this->addFlash(
				'success',
				'Клиент успешно сохранен.'
			);

			return $this->redirectToRoute('clients_client_list');
		}

		return $this->render(
			'CoreBundle:Clients/Client:new.html.twig',
			['form' => $form->createView()]
		);
	}

	public function showAction($client_id)
	{
		$client = $this->clientManager->findByID($client_id);

		if (!$client) {
			throw $this->createNotFoundException(
				sprintf(
					'No client "%s" found',
					$client_id
				)
			);
		}

		$form = $this->createForm('clients_client');
		$form->setData($client);

		return $this->render(
			'CoreBundle:Clients/Client:show.html.twig',
			[
				'client' => $client,
				'form'   => $form->createView(),
			]
		);
	}

	public function updateAction($client_id)
	{
		$client = $this->clientManager->findByID($client_id);

		if (!$client) {
			throw $this->createNotFoundException(
				sprintf(
					'No client "%s" found',
					$client_id
				)
			);
		}

		$form = $this->createForm('clients_client');
		$form->setData($client);
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$this->clientManager->update($client);

			$this->addFlash(
				'success',
				'Клиент успешно отредактирован.'
			);

			return $this->redirectToRoute('clients_client_list');
		}

		return $this->render(
			'CoreBundle:Clients/Client:show.html.twig',
			[
				'client' => $client,
				'form'   => $form->createView(),
			]
		);
	}

	public function deleteAction($client_id)
	{
		$client = $this->clientManager->findByID($client_id);

		if ($client) {
			$this->clientManager->delete($client);

			$this->addFlash(
				'success',
				'Клиент успешно удален.'
			);
		}

		return $this->redirectToRoute('clients_client_list');
	}
}