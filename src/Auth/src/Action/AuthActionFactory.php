<?php
/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 06.12.2017
 * Time: 16:42
 */

namespace Auth\Action;


use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class AuthActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthAction($container->get(AuthenticationService::class));
    }
}