<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'App\Controller\MainController' shared autowired service.

$this->services['App\Controller\MainController'] = $instance = new \App\Controller\MainController(($this->privates['App\Calculator\Parser'] ?? $this->load('getParserService.php')));

$instance->setContainer((new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'http_kernel' => ['services', 'http_kernel', 'getHttpKernelService', false],
    'parameter_bag' => ['privates', 'parameter_bag', 'getParameterBagService', false],
    'request_stack' => ['services', 'request_stack', 'getRequestStackService', false],
    'router' => ['services', 'router', 'getRouterService', false],
    'session' => ['services', 'session', 'getSessionService.php', true],
]))->withContext('App\\Controller\\MainController', $this));

return $instance;