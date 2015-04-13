<?php

namespace Podorozhny\CoreBundle\Controller\Backend;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Podorozhny\CoreBundle\Controller\AbstractController;
use Podorozhny\Manager\Backend\UserManager;

class UserController
	extends AbstractController
{
	public function __construct(
		EntityManagerInterface $entityManager,
		PaginatorInterface $paginator,
		UserManager $userManager
	) {
		$this->entityManager = $entityManager;
		$this->paginator     = $paginator;
		$this->userManager   = $userManager;
	}

	public function listAction($page)
	{
		$query = $this->entityManager->createQuery(
			'SELECT u
			FROM Backend:User u
			ORDER BY u.createdAt DESC'
		);

		$pagination = $this->paginator->paginate(
			$query,
			$this->getRequest()->query->get('page', $page),
			10
		);

		return $this->render(
			'CoreBundle:Backend/User:list.html.twig',
			['pagination' => $pagination]
		);
	}

	public function newAction()
	{
		$form = $this->createForm('backend_user');

		return $this->render(
			'CoreBundle:Backend/User:new.html.twig',
			['form' => $form->createView()]
		);
	}

	public function createAction()
	{
		$user = $this->userManager->create();

		$form = $this->createForm('backend_user');
		$form->setData($user);
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$this->userManager->update($user);

			$this->addFlash(
				'success',
				'Сотрудник успешно сохранен.'
			);

			return $this->redirectToRoute('backend_user_list');
		}

		return $this->render(
			'CoreBundle:Backend/User:new.html.twig',
			['form' => $form->createView()]
		);
	}

	public function showAction($user_id)
	{
		$user = $this->userManager->findByID($user_id);

		if (!$user) {
			throw $this->createNotFoundException(
				sprintf(
					'No user "%s" found',
					$user_id
				)
			);
		}

		$form = $this->createForm('backend_user');
		$form->setData($user);

		return $this->render(
			'CoreBundle:Backend/User:show.html.twig',
			[
				'user' => $user,
				'form' => $form->createView(),
			]
		);
	}

	public function updateAction($user_id)
	{
		$user = $this->userManager->findByID($user_id);

		if (!$user) {
			throw $this->createNotFoundException(
				sprintf(
					'No user "%s" found',
					$user_id
				)
			);
		}

		$form = $this->createForm('backend_user');
		$form->setData($user);
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$this->userManager->update($user);

			$this->addFlash(
				'success',
				'Сотрудник успешно отредактирован.'
			);

			return $this->redirectToRoute('backend_user_list');
		}

		return $this->render(
			'CoreBundle:Backend/User:show.html.twig',
			[
				'user' => $user,
				'form' => $form->createView(),
			]
		);
	}

	public function deleteAction($user_id)
	{
		$user = $this->userManager->findByID($user_id);

		if ($user) {
			$this->userManager->delete($user);

			$this->addFlash(
				'success',
				'Сотрудник успешно уволен.'
			);
		}

		return $this->redirectToRoute('backend_user_list');
	}
}