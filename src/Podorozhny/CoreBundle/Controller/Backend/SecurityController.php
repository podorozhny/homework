<?php

namespace Podorozhny\CoreBundle\Controller\Backend;

use Podorozhny\Model\Backend\UserInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Security;
use Podorozhny\CoreBundle\Controller\AbstractController;
use Podorozhny\Manager\Backend\UserManager;

class SecurityController
	extends AbstractController
{
	private $userManager;

	public function __construct(UserManager $userManager)
	{
		$this->userManager = $userManager;
	}

	public function loginAction()
	{
		if (true === $this->getSecurityContext()
				->isGranted(UserInterface::ROLE_DEFAULT)
		) {
			return $this->redirectToRoute('backend_home');
		}

		$error = null;
		if ($this->getRequest()->attributes->has(
			Security::AUTHENTICATION_ERROR
		)
		) {
			$error = $this->getRequest()->attributes->get(
				Security::AUTHENTICATION_ERROR
			);
		} else {
			$error =
				$this->getSession()
					->get(
						Security::AUTHENTICATION_ERROR,
						null
					);
			$this->getSession()
				->remove(
					Security::AUTHENTICATION_ERROR
				);
		}

		$form = $this->createForm('backend_login');

		if (!is_null($error)) {
			$form->get('password')
				->addError(new FormError('Неправильная почта или пароль'));
		}

		return $this->render(
			'CoreBundle:Backend/Security:login.html.twig',
			[
				'form' => $form->createView(),
			]
		);
	}
}