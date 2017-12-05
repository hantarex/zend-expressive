<?php
namespace Auth\Action;


use Auth\Form\AuthForm;
use Auth\MyAuthAdapter;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\ConfigProvider;
use Zend\Form\View\Helper\Form;
use Zend\Form\View\HelperConfig;
use Zend\View\HelperPluginManager;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplatePathStack;
use Zend\View\View;

class LoginAction implements MiddlewareInterface
{
    protected $viewHelper;
    protected $phpRender;
    private $auth;
    private $authAdapter;
    private $template;

    public function __construct(
        TemplateRendererInterface $template,
        AuthenticationService $auth,
        MyAuthAdapter $authAdapter,
        HelperPluginManager $viewHelper
    ) {
        $this->template    = $template;
        $this->auth        = $auth;
        $this->authAdapter = $authAdapter;
        $this->viewHelper=$viewHelper;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $form = new AuthForm();
        if ($request->getMethod() === 'POST') {
            return $this->authenticate($request);
        }
        
        $this->viewHelper=(new HelperConfig())->configureServiceManager($this->viewHelper);
        $phpRender=new PhpRenderer();
        $phpRender->setHelperPluginManager($this->viewHelper);
        $phpRender->setResolver(new TemplatePathStack([
            'script_paths'=>[
                __DIR__."/../../"
            ]
        ]));
        
        return new HtmlResponse($this->template->render('auth::login', [
            'error' => 'test',
            'form' =>  $phpRender->partial("templates/mvc/form",['form'=>$form])
        ]));
    }

    public function authenticate(ServerRequestInterface $request)
    {
        $params = $request->getParsedBody();

        if (empty($params['username'])) {
            return new HtmlResponse($this->template->render('auth::login', [
                'error' => 'The username cannot be empty',
            ]));
        }

        if (empty($params['password'])) {
            return new HtmlResponse($this->template->render('auth::login', [
                'username' => $params['username'],
                'error'    => 'The password cannot be empty',
            ]));
        }

        $this->authAdapter->setUsername($params['username']);
        $this->authAdapter->setPassword($params['password']);

        $result = $this->auth->authenticate();
        if (!$result->isValid()) {
            return new HtmlResponse($this->template->render('auth::login', [
                'username' => $params['username'],
                'error'    => 'The credentials provided are not valid',
            ]));
        }

        return new RedirectResponse('/admin');
    }
}