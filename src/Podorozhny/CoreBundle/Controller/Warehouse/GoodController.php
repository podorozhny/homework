<?php

namespace Podorozhny\CoreBundle\Controller\Warehouse;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Podorozhny\CoreBundle\Controller\AbstractController;
use Podorozhny\Manager\Warehouse\GoodManager;

class GoodController
	extends AbstractController
{
	public function __construct(
		EntityManagerInterface $entityManager,
		PaginatorInterface $paginator,
		GoodManager $goodManager
	) {
		$this->entityManager      = $entityManager;
		$this->paginator          = $paginator;
		$this->goodManager = $goodManager;
	}
	
	public function listAction($page)
	{
		$query = $this->entityManager->createQuery(
			'SELECT g
			FROM Warehouse:Good g
			ORDER BY g.createdAt DESC'
		);
		
		$pagination = $this->paginator->paginate(
			$query,
			$this->getRequest()->query->get('page', $page),
			10
		);
		
		return $this->render(
			'CoreBundle:Warehouse/Good:list.html.twig',
			['pagination' => $pagination]
		);
	}
	
	public function newAction()
	{
		$form = $this->createForm('warehouse_good');
		
		return $this->render(
			'CoreBundle:Warehouse/Good:new.html.twig',
			['form' => $form->createView()]
		);
	}
	
	public function createAction()
	{
		$good = $this->goodManager->create();
		
		$form = $this->createForm('warehouse_good');
		$form->setData($good);
		$form->handleRequest($this->getRequest());
		
		if ($form->isValid()) {
			$this->goodManager->update($good);
			
			$this->addFlash(
				'success',
				'Товар успешно сохранен.'
			);
			
			return $this->redirectToRoute('warehouse_good_list');
		}
		
		return $this->render(
			'CoreBundle:Warehouse/Good:new.html.twig',
			['form' => $form->createView()]
		);
	}
	
	public function showAction($good_id)
	{
		$good = $this->goodManager->findByID($good_id);
		
		if (!$good) {
			throw $this->createNotFoundException(
				sprintf(
					'No good "%s" found',
					$good_id
				)
			);
		}
		
		$form = $this->createForm('warehouse_good');
		$form->setData($good);
		
		return $this->render(
			'CoreBundle:Warehouse/Good:show.html.twig',
			[
				'good' => $good,
				'form'        => $form->createView(),
			]
		);
	}
	
	public function updateAction($good_id)
	{
		$good = $this->goodManager->findByID($good_id);
		
		if (!$good) {
			throw $this->createNotFoundException(
				sprintf(
					'No good "%s" found',
					$good_id
				)
			);
		}
		
		$form = $this->createForm('warehouse_good');
		$form->setData($good);
		$form->handleRequest($this->getRequest());
		
		if ($form->isValid()) {
			$this->goodManager->update($good);
			
			$this->addFlash(
				'success',
				'Товар успешно отредактирован.'
			);
			
			return $this->redirectToRoute('warehouse_good_list');
		}
		
		return $this->render(
			'CoreBundle:Warehouse/Good:show.html.twig',
			[
				'good' => $good,
				'form'        => $form->createView(),
			]
		);
	}
	
	public function deleteAction($good_id)
	{
		$good = $this->goodManager->findByID($good_id);
		
		if ($good) {
			$this->goodManager->delete($good);
			
			$this->addFlash(
				'success',
				'Товар успешно удален.'
			);
		}
		
		return $this->redirectToRoute('warehouse_good_list');
	}
}