<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'App\Calculator\Parser' shared autowired service.

return $this->privates['App\Calculator\Parser'] = new \App\Calculator\Parser(($this->privates['App\Calculator\Calculator'] ?? ($this->privates['App\Calculator\Calculator'] = new \App\Calculator\Calculator())));
