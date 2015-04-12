<?php

use Symfony\Component\HttpFoundation\Request;

if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1',])
	&& substr($_SERVER['REMOTE_ADDR'], 0, 11) !== '192.168.100'
    && substr($_SERVER['REMOTE_ADDR'], 0, 7) !== '178.167'
) {
    header('HTTP/1.0 403 Forbidden');
    exit('Get the fuck outta here!');
}

$loader = require_once __DIR__ . '/../app/bootstrap.php.cache';

require_once __DIR__ . '/../app/AppKernel.php';

$kernel  = new AppKernel('test', true);
$request = Request::createFromGlobals();

Request::enableHttpMethodParameterOverride();

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);