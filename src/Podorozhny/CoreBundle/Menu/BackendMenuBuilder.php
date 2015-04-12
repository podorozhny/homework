<?php

namespace Podorozhny\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\SecurityContextInterface;

class BackendMenuBuilder
{
	protected $factory;
	protected $securityContext;
	protected $request;

	public function __construct(
		FactoryInterface $factory,
		SecurityContextInterface $securityContext,
		RequestStack $requestStack
	) {
		$this->factory         = $factory;
		$this->securityContext = $securityContext;
		$this->requestStack    = $requestStack;
	}

	public function createMainMenu()
	{
		$menu = $this->factory->createItem('root');
		$menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

//		$menu->addChild(
//			'<i class="fa fa-times"></i>',
//			['uri' => 'javascript:void(0)']
//		)
//			->setAttribute('class', 'visible-xs visible-sm')
//			->setLinkAttribute('class', 'site-menu-toggle text-center');
//
//		$menu->addChild('Помощь', ['route' => 'support_page_help']);
//
//		$menu->addChild('Обратная связь', ['route' => 'support_feedback_new']);

		$menu->addChild(
			'user',
//				[
//					'label' => $this->securityContext->getToken()
//						->getUser()
//						->getEmail()
//				]
			[
				'label' => 'Прокопенко Станислав Михайлович'
			]
		)
			->setAttribute('dropdown', true);

//			$menu['user']->addChild(
//				'Мои объявления',
//				['route' => 'backend_profile_adverts']
//			);

		$menu['user']->addChild(
			'Выход',
			['route' => 'backend_security_logout']
		);

		return $menu;
	}

	public function createSidebarMenu()
	{
		$menu = $this->factory->createItem('root');

		$menu->setChildrenAttribute('class', 'nav nav-sidebar');

		$menu->addChild(
			'Главная',
			['route' => 'backend_home']
		);

		$menu->addChild(
			'Отчеты',
			['uri' => 'javascript:void(0)']
		);

		$menu->addChild(
			'Клиенты',
			[
				'route'      => 'clients_client_list',
				'attributes' => ['divider_prepend' => true]
			]
		)
			->setCurrent($this->isCurrent(['clients_client_']));

		$menu->addChild(
			'Финансы',
			[
				'route'      => 'finance_transaction_list',
				'attributes' => ['divider_prepend' => true]
			]
		)
			->setCurrent($this->isCurrent(['finance_transaction_']));

		$menu->addChild(
			'Склад',
			[
				'route'      => 'warehouse_good_list',
				'attributes' => ['divider_prepend' => true]
			]
		)
			->setCurrent($this->isCurrent(['warehouse_good_']));

		return $menu;
	}

	private function isCurrent($routes = array())
	{
		$requestRoute =
			$this->requestStack->getCurrentRequest()
				->get('_route');

		foreach ($routes as $route) {
			if (mb_substr($requestRoute, 0, mb_strlen($route)) === $route) {
				return true;
			}
		}

		return false;
	}
}