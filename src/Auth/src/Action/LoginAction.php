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
use Zend\View\Renderer\PhpRenderer;

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
        PhpRenderer $phpRender
    ) {
        $this->template    = $template;
        $this->auth        = $auth;
        $this->authAdapter = $authAdapter;
        $this->phpRender=$phpRender;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $form = new AuthForm();
        if ($request->getMethod() === 'POST') {
            return $this->authenticate($request,$form);
        }

        return new HtmlResponse($this->template->render('auth::login', [
            'error' => 'test',
            'form' =>  $this->phpRender->partial("templates/mvc/form",['form'=>$form])
        ]));
    }

    public function authenticate(ServerRequestInterface $request, AuthForm $form)
    {
        $params = $request->getParsedBody();

        if (empty($params['username'])) {
            return new HtmlResponse($this->template->render('auth::login', [
                'error' => 'The username cannot be empty',
                'form' =>  $this->phpRender->partial("templates/mvc/form",['form'=>$form])
            ]));
        }

        if (empty($params['password'])) {
            return new HtmlResponse($this->template->render('auth::login', [
                'username' => $params['username'],
                'error'    => 'The password cannot be empty',
                'form' =>  $this->phpRender->partial("templates/mvc/form",['form'=>$form])
            ]));
        }

        $this->authAdapter->setUsername($params['username']);
        $this->authAdapter->setPassword($params['password']);

        $result = $this->auth->authenticate();
        if (!$result->isValid()) {
            return new HtmlResponse($this->template->render('auth::login', [
                'username' => $params['username'],
                'error'    => 'The credentials provided are not valid',
                'form' =>  $this->phpRender->partial("templates/mvc/form",['form'=>$form])
            ]));
        }

        return new RedirectResponse('/admin');
    }
}