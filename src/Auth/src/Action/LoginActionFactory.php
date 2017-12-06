<?php
namespace Auth\Action;

use Auth\MyAuthAdapter;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\ConfigProvider;
use Zend\View\HelperPluginManager;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplatePathStack;

class LoginActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $viewHelper=$container->get(HelperPluginManager::class);
        $viewHelper->configure((new ConfigProvider())->getViewHelperConfig());

        $phpRender=$container->get(PhpRenderer::class);
        $phpRender->setHelperPluginManager($viewHelper);
        $phpRender->setResolver(new TemplatePathStack([
            'script_paths'=>[
                __DIR__."/../../"
            ]
        ]));
        
        return new LoginAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(AuthenticationService::class),
            $container->get(MyAuthAdapter::class),
            $phpRender
        );
    }
}