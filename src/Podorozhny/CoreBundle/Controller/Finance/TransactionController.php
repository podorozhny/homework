<?php

namespace Podorozhny\CoreBundle\Controller\Finance;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Podorozhny\CoreBundle\Controller\AbstractController;
use Podorozhny\Manager\Finance\TransactionManager;

class TransactionController
	extends AbstractController
{
	public function __construct(
		EntityManagerInterface $entityManager,
		PaginatorInterface $paginator,
		TransactionManager $transactionManager
	) {
		$this->entityManager      = $entityManager;
		$this->paginator          = $paginator;
		$this->transactionManager = $transactionManager;
	}
	
	public function listAction($page)
	{
		$query = $this->entityManager->createQuery(
			'SELECT t
			FROM Finance:Transaction t
			ORDER BY t.createdAt DESC'
		);
		
		$pagination = $this->paginator->paginate(
			$query,
			$this->getRequest()->query->get('page', $page),
			10
		);
		
		return $this->render(
			'CoreBundle:Finance/Transaction:list.html.twig',
			['pagination' => $pagination]
		);
	}
	
	public function newAction()
	{
		$form = $this->createForm('finance_transaction');
		
		return $this->render(
			'CoreBundle:Finance/Transaction:new.html.twig',
			['form' => $form->createView()]
		);
	}
	
	public function createAction()
	{
		$transaction = $this->transactionManager->create();
		
		$form = $this->createForm('finance_transaction');
		$form->setData($transaction);
		$form->handleRequest($this->getRequest());
		
		if ($form->isValid()) {
			$this->transactionManager->update($transaction);
			
			$this->addFlash(
				'success',
				'Транзакция успешно сохранена.'
			);
			
			return $this->redirectToRoute('finance_transaction_list');
		}
		
		return $this->render(
			'CoreBundle:Finance/Transaction:new.html.twig',
			['form' => $form->createView()]
		);
	}
	
	public function showAction($transaction_id)
	{
		$transaction = $this->transactionManager->findByID($transaction_id);
		
		if (!$transaction) {
			throw $this->createNotFoundException(
				sprintf(
					'No transaction "%s" found',
					$transaction_id
				)
			);
		}
		
		$form = $this->createForm('finance_transaction');
		$form->setData($transaction);
		
		return $this->render(
			'CoreBundle:Finance/Transaction:show.html.twig',
			[
				'transaction' => $transaction,
				'form'        => $form->createView(),
			]
		);
	}
	
	public function updateAction($transaction_id)
	{
		$transaction = $this->transactionManager->findByID($transaction_id);
		
		if (!$transaction) {
			throw $this->createNotFoundException(
				sprintf(
					'No transaction "%s" found',
					$transaction_id
				)
			);
		}
		
		$form = $this->createForm('finance_transaction');
		$form->setData($transaction);
		$form->handleRequest($this->getRequest());
		
		if ($form->isValid()) {
			$this->transactionManager->update($transaction);
			
			$this->addFlash(
				'success',
				'Транзакция успешно отредактирована.'
			);
			
			return $this->redirectToRoute('finance_transaction_list');
		}
		
		return $this->render(
			'CoreBundle:Finance/Transaction:show.html.twig',
			[
				'transaction' => $transaction,
				'form'        => $form->createView(),
			]
		);
	}
	
	public function deleteAction($transaction_id)
	{
		$transaction = $this->transactionManager->findByID($transaction_id);
		
		if ($transaction) {
			$this->transactionManager->delete($transaction);
			
			$this->addFlash(
				'success',
				'Транзакция успешно удалена.'
			);
		}
		
		return $this->redirectToRoute('finance_transaction_list');
	}
}