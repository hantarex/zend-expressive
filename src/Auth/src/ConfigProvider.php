<?php
namespace Auth;

use Auth\Action\LoginAction;
use Auth\Action\LoginActionFactory;
use Auth\AuthenticationServiceFactory;
use Auth\MyAuthAdapter;
use Auth\MyAuthAdapterFactory;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Service\ViewHelperManagerFactory;

// And update the following method:


class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    public function getDependencies()
    {
        return [
            'factories' => [
                LoginAction::class => LoginActionFactory::class,
                AuthenticationService::class => AuthenticationServiceFactory::class,
                MyAuthAdapter::class => MyAuthAdapterFactory::class,
                'ViewHelperManager' => ViewHelperManagerFactory::class
            ],
        ];
    }

    public function getTemplates()
    {
        return [
            'paths' => [
                'auth'    => [__DIR__ . '/../templates/auth'],
            ],
        ];
    }
}