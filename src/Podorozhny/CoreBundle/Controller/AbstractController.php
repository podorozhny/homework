<?php

namespace Podorozhny\CoreBundle\Controller;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

abstract class AbstractController
{
	protected $formFactory;
	protected $router;
	protected $translator;
	protected $securityContext;
	protected $templating;
	protected $session;
	protected $requestStack;

	public function setFormFactory(FormFactoryInterface $formFactory)
	{
		$this->formFactory = $formFactory;
	}

	public function getFormFactory()
	{
		return $this->formFactory;
	}

	public function setRouter(RouterInterface $router)
	{
		$this->router = $router;
	}

	public function getRouter()
	{
		return $this->router;
	}

	public function setTranslator(TranslatorInterface $translator)
	{
		$this->translator = $translator;
	}

	public function getTranslator()
	{
		return $this->translator;
	}

	public function setSecurityContext(
		SecurityContextInterface $securityContext
	) {
		$this->securityContext = $securityContext;
	}

	public function getSecurityContext()
	{
		return $this->securityContext;
	}

	public function setTemplating(EngineInterface $templating)
	{
		$this->templating = $templating;
	}

	public function getTemplating()
	{
		return $this->templating;
	}

	public function setSession(SessionInterface $session)
	{
		$this->session = $session;
	}

	public function getSession()
	{
		return $this->session;
	}

	public function setRequestStack(RequestStack $requestStack)
	{
		$this->requestStack = $requestStack;
	}

	public function getRequestStack()
	{
		return $this->requestStack;
	}

	public function generateUrl(
		$route,
		array $parameters = [],
		$referenceType = UrlGeneratorInterface::ABSOLUTE_PATH
	) {
		return $this->router->generate($route, $parameters, $referenceType);
	}

	public function redirect($url, $status = 302)
	{
		return new RedirectResponse($url, $status);
	}

	public function redirectToRoute(
		$route,
		array $parameters = [],
		$status = 302
	) {
		return $this->redirect(
			$this->generateUrl($route, $parameters),
			$status
		);
	}

	protected function addFlash($type, $message)
	{
		$this->session->getFlashBag()
			->add($type, $message);
	}

	public function getRequest()
	{
		return $this->requestStack->getCurrentRequest();
	}

	public function getUser()
	{
		if (null === $token = $this->securityContext->getToken()) {
			return null;
		}
		if (!is_object($user = $token->getUser())) {
			return null;
		}

		return $user;
	}

	public function createForm($type, $data = null, array $options = [])
	{
		return $this->formFactory->create($type, $data, $options);
	}

	public function render(
		$view,
		array $parameters = [],
		Response $response = null
	) {
		return $this->templating->renderResponse($view, $parameters, $response);
	}

	public function createNotFoundException(
		$message = 'Not Found',
		\Exception $previous = null
	) {
		return new NotFoundHttpException($message, $previous);
	}

	public function createAccessDeniedException(
		$message = 'Access Denied',
		\Exception $previous = null
	) {
		return new AccessDeniedException($message, $previous);
	}
}