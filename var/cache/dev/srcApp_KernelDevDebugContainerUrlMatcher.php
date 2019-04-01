<?php

use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherTrait;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class srcApp_KernelDevDebugContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    use PhpMatcherTrait;

    public function __construct(RequestContext $context)
    {
        $this->context = $context;
        $this->staticRoutes = [
            '/healthcheck' => [[['_route' => 'healthCheck', '_controller' => 'App\\Controller\\MainController::healthCheck'], null, ['GET' => 0], null, false, false, null]],
            '/calc' => [[['_route' => 'calculate', '_controller' => 'App\\Controller\\MainController::calculate'], null, ['POST' => 0], null, false, false, null]],
        ];
    }
}
