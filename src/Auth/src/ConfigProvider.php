<?php
namespace Auth;

use Auth\Action\AuthAction;
use Auth\Action\AuthActionFactory;
use Auth\Action\LoginAction;
use Auth\Action\LoginActionFactory;
use Auth\AuthenticationServiceFactory;
use Auth\MyAuthAdapter;
use Auth\MyAuthAdapterFactory;
use Zend\Authentication\AuthenticationService;
use Zend\Form\Form;
use Zend\Form\FormAbstractServiceFactory;
use Zend\Mvc\Service\ViewHelperManagerFactory;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\View\HelperPluginManager;
use Zend\View\Renderer\PhpRenderer;

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
                AuthAction::class => AuthActionFactory::class,
                AuthenticationService::class => AuthenticationServiceFactory::class,
                MyAuthAdapter::class => MyAuthAdapterFactory::class,
                HelperPluginManager::class => ViewHelperManagerFactory::class,
                PhpRenderer::class => InvokableFactory::class
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