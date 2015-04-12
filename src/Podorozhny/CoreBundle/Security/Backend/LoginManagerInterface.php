<?php

namespace Podorozhny\CoreBundle\Security\Backend;

use Podorozhny\Model\Backend\UserInterface;
use Symfony\Component\HttpFoundation\Response;

interface LoginManagerInterface
{
    public function loginUser(
        $firewallName,
        UserInterface $user,
        Response $response = null
    );
}